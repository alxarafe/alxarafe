<?php
/**
 * Copyright (C) 2022-2023  Rafael San José Tovar   <info@rsanjoseo.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace Alxarafe\Database;

use Alxarafe\Core\Singletons\Config;
use Alxarafe\Core\Singletons\Debug;
use Alxarafe\Core\Singletons\PhpFileCache;
use DebugBar\DebugBarException;
use Symfony\Component\Yaml\Yaml;
use function Alxarafe\Core\Helpers\count;
use const Alxarafe\Core\Helpers\DEFAULT_INTEGER_SIZE;
use const Alxarafe\Core\Helpers\DEFAULT_STRING_LENGTH;

/**
 * The Schema class contains static methods that allow you to manipulate the
 * database. It is used to create and modify tables and indexes in the database.
 */
class Schema
{
    public const TYPE_INTEGER = 'integer';
    public const TYPE_FLOAT = 'float';
    public const TYPE_DECIMAL = 'decimal';
    public const TYPE_STRING = 'string';
    public const TYPE_TEXT = 'text';
    public const TYPE_DATE = 'date';
    public const TYPE_TIME = 'time';
    public const TYPE_DATETIME = 'datetime';
    public const TYPE_BOOLEAN = 'bool';

    public const TYPES = [
        self::TYPE_INTEGER => ['tinyint', 'smallint', 'mediumint', 'int', 'bigint'],
        self::TYPE_FLOAT => ['real', 'double'],
        self::TYPE_DECIMAL => ['decimal', 'numeric'],
        self::TYPE_STRING => ['char', 'varchar'],
        self::TYPE_TEXT => ['tinytext', 'text', 'mediumtext', 'longtext', 'blob'],
        self::TYPE_DATE => ['date'],
        self::TYPE_TIME => ['time'],
        self::TYPE_DATETIME => ['datetime', 'timestamp'],
        self::TYPE_BOOLEAN => ['boolean'],
    ];
    public const YAML_CACHE_TABLES_FOLDER = 'models';

    /**
     * Carriage Return and Line Feed
     */
    const CRLF = "\r\n";
    const DB_INDEX_TYPE = 'bigint (20) unsigned';

    public static array $tables = [];

    /**
     * Contains the database structure data.
     * Each table is an index of the associative array.
     *
     * @var array
     */
    public static array $bbddStructure;

    /**
     * Return true if $tableName exists in database
     *
     * @param string $tableName
     *
     * @return bool
     * @throws DebugBarException
     */
    public static function tableExists($tableName): bool
    {
        $tableNameWithPrefix = Config::$dbPrefix . $tableName;
        $dbName = Config::$dbName;
        $sql = "SELECT COUNT(*) AS Total FROM information_schema.tables WHERE table_schema = '{$dbName}' AND table_name='{$tableNameWithPrefix}'";

        $data = Engine::select($sql);
        $result = reset($data);

        return $result['Total'] === '1';
    }

    private static function getFields($tableName): array
    {
        $yamlFilename = PhpFileCache::getYamlFileName(self::YAML_CACHE_TABLES_FOLDER, $tableName);
        if (file_exists($yamlFilename)) {
            return PhpFileCache::loadYamlFile(self::YAML_CACHE_TABLES_FOLDER, $tableName);
        }

        if (empty(self::$tables)) {
            self::$tables = YamlSchema::getTables();
        }

        $yamlSourceFilename = self::$tables[$tableName];
        if (!file_exists($yamlSourceFilename)) {
            dump('No existe el archivo ' . $yamlSourceFilename);
        }

        $data = Yaml::parseFile($yamlSourceFilename);

        $result = [];
        foreach ($data as $key => $datum) {
            $datum['key'] = $key;
            $result[$key] = Schema::normalize($datum);
        }

        /*
        Igual conviene crear una clase:
        - DBSchema (con los datos de la base de datos real)
        - DefinedSchema (con los datos definidos)
        y que Schema cree o adapte según los datos de ambas. Que cada una lleve lo suyo

        Que el resultado se guarde en el yaml y que se encargue de realizar las conversines
    oportunas siempre que no suponga una pérdida de datos.
        */

        return $result;
    }

    private static function getIndexes($tableName): array
    {
        $result = [];
        return $result;
    }

    private static function getRelated($tableName): array
    {
        $result = [];
        return $result;
    }

    private static function getSeed($tableName): array
    {
        $result = [];
        return $result;
    }

    public static function checkStructure(string $tableName, bool $create)
    {
        if (!empty(self::$bbddStructure[$tableName])) {
            return;
        }

        $structure = [];
        $structure['fields'] = self::getFields($tableName);
        $structure['indexes'] = self::getIndexes($tableName);
        $structure['related'] = self::getRelated($tableName);
        if ($create) {
            $structure['seed'] = self::getSeed($tableName);
        }
        self::$bbddStructure[$tableName] = $structure;
    }

    /**
     * Normalize an array that has the file structure defined in the model by setStructure,
     * so that it has fields with all the values it must have. Those that do not exist are
     * created with the default value, avoiding having to do the check each time, or
     * calculating their value based on the data provided by the other fields.
     *
     * It also ensures that the keys and default values exist as an empty array if they
     * did not exist.
     *
     * @param array  $structure
     * @param string $tableName
     *
     * @return array
     */
    public static function setNormalizedStructure(array $structure, string $tableName): array
    {
        $ret['keys'] = $structure['keys'] ?? [];
        $ret['values'] = $structure['values'] ?? [];
        foreach ($structure['fields'] as $key => $value) {
            $ret['fields'][$key] = self::normalizeField($tableName, $key, $value);
        }
        return $ret;
    }

    /**
     * Take the definition of a field, and make sure you have all the information
     * that is necessary for its creation or maintenance, calculating the missing
     * data if possible.
     * It can cause an exception if some vital data is missing, but this should
     * only occur at the design stage.
     *
     * @param string $tableName
     * @param string $field
     * @param array  $structure
     *
     * @return array
     */
    protected static function normalizeField(string $tableName, string $field, array $structure): array
    {
        if (!isset($structure['type'])) {
            dump("The type parameter is mandatory in {$field}. Error in table " . $tableName);
            dump($structure);
        }

        $dbType = $structure['type'];

        if ($dbType == 'boolean') {
            $dbType = 'tinyint';
            $structure['min'] = 0;
            $structure['max'] = 1;
        }

        if ($dbType == 'int' || $dbType == 'tinyint' || $dbType == 'number') {
            $type = 'number';
        } else {
            if ($dbType == 'float') {
                $type = 'float';
            } else {
                if ($dbType == 'double') {
                    $type = 'double';
                } else {
                    if ($dbType == 'char' || $dbType == 'varchar' || $dbType == 'text') {
                        $type = 'text';
                    } else {
                        if ($dbType == 'date') {
                            $type = 'date';
                        } else {
                            if ($dbType == 'datetime' || $dbType == 'timestamp') {
                                $type = 'datetime-local';
                            } else {
                                echo "<p>Check Schema.normalizeField if you think that {$dbType} might be necessary.</p>";
                                die("Type {$dbType} is not valid for field {$field} of table {$tableName}");
                            }
                        }
                    }
                }
            }
        }

        $min = (isset($structure['min'])) ? $structure['min'] : 0;
        $max = (isset($structure['max'])) ? $structure['max'] : 0;
        $default = (isset($structure['default'])) ? $structure['default'] : null;
        $label = (isset($structure['label'])) ? $structure['label'] : $field;
        $unsigned = (!isset($structure['unsigned']) || $structure['unsigned'] == true);
        $null = ((isset($structure['null'])) && $structure['null'] == true);

        $ret = [];
        if ($type == 'text') {
            if ($max == 0) {
                $max = DEFAULT_STRING_LENGTH;
            }
            $dbType = "$dbType($max)";
            $ret['pattern'] = '.{' . $min . ',' . $max . '}';
        } else {
            if ($type == 'number') {
                if ($default === true) {
                    $default = '1';
                }
                if ($max == 0) {
                    $tmpLength = DEFAULT_INTEGER_SIZE;
                    $max = pow(10, $tmpLength) - 1;
                } else {
                    $tmpLength = strlen($max);
                }

                if ($min == 0) {
                    $min = $unsigned ? 0 : -$max;
                } else {
                    if ($tmpLength < strlen($min)) {
                        $tmpLength = strlen($min);
                    }
                }

                if (isset($structure['decimals'])) {
                    $decimales = $structure['decimals'];
                    $precision = pow(10, -$decimales);
                    $tmpLength += $decimales;
                    $dbType = "decimal($tmpLength,$decimales)" . ($unsigned ? ' unsigned' : '');
                    $ret['min'] = $min == 0 ? 0 : ($min < 0 ? $min - 1 + $precision : $min + 1 - $precision);
                    $ret['max'] = $max > 0 ? $max + 1 - $precision : $max - 1 + $precision;
                } else {
                    $precision = null;
                    $dbType = "integer($tmpLength)" . ($unsigned ? ' unsigned' : '');
                    $ret['min'] = $min;
                    $ret['max'] = $max;
                }
            }
        }

        $ret['type'] = $type;
        $ret['dbtype'] = $dbType;
        $ret['default'] = $default;
        $ret['null'] = $null;
        $ret['label'] = $label;
        if (isset($precision)) {
            $ret['step'] = $precision;
        }
        if (isset($structure['key'])) {
            $ret['key'] = $structure['key'];
        }
        if (isset($structure['placeholder'])) {
            $ret['placeholder'] = $structure['placeholder'];
        }
        if (isset($structure['extra'])) {
            $ret['extra'] = $structure['extra'];
        }
        if (isset($structure['help'])) {
            $ret['help'] = $structure['help'];
        }
        if (isset($structure['unique']) && $structure['unique']) {
            $ret['unique'] = $structure['unique'];
        }

        if (isset($structure['relations'][$field]['table'])) {
            $ret['relation'] = [
                'table' => $structure['relations'][$field]['table'],
                'id' => isset($structure['relations'][$field]['id']) ? $structure['relations'][$field]['id'] : 'id',
                'name' => isset($structure['relations'][$field]['name']) ? $structure['relations'][$field]['name'] : 'name',
            ];
        }

        return $ret;
    }

    private static function getTypeOf(string $type): string
    {
        foreach (self::TYPES as $index => $types) {
            if (in_array(strtolower($type), $types)) {
                return $index;
            }
        }
        Debug::addMessage('messages', $type . ' not found in DBSchema::getTypeOf()');
        return 'text';
    }

    private static function splitType(string $originalType): array
    {
        $replacesSources = [
            'character varying',
            // 'timestamp without time zone',
            'double precision',
        ];
        $replacesDestination = [
            'varchar',
            // 'timestamp',
            'double',
        ];
        $modifiedType = (str_replace($replacesSources, $replacesDestination, $originalType));

        if ($originalType !== $modifiedType) {
            Debug::addMessage('messages', "XML: Uso de '{$originalType}' en lugar de '{$modifiedType}'.");
        }
        $explode = explode(' ', strtolower($modifiedType));

        $pos = strpos($explode[0], '(');
        if ($pos > 0) {
            $begin = $pos + 1;
            $end = strpos($explode[0], ')');
            $type = substr($explode[0], 0, $pos);
            $length = substr($explode[0], $begin, $end - $begin);
        } else {
            $type = $explode[0];
            $length = null;
        }

        $pos = array_search('unsigned', $explode, true);
        $unsigned = $pos ? 'yes' : 'no';

        $pos = array_search('zerofill', $explode, true);
        $zerofill = $pos ? 'yes' : 'no';

        return ['type' => $type, 'length' => $length, 'unsigned' => $unsigned, 'zerofill' => $zerofill];
    }

    /**
     * Toma los datos del fichero de definición de una tabla y genera el definitivo.
     *
     * @author  Rafael San José Tovar <rafael.sanjose@x-netdigital.com>
     * @version 2022.1224
     *
     * @param array $structure
     *
     * @return array
     */
    protected static function normalize(array $structure): array
    {
        $column = [];
        $key = (string) $structure['key'];
        $type = (string) $structure['type'];
        $column['key'] = $key;

        /**
         * Entrada:
         * - type es el tipo lógico del campo y tiene que estar definido como índice en
         *   TYPES, o ser uno de los predefinidos como 'autoincrement', 'relationship', etc.
         *
         * Salida:
         * - type queda intacto.
         * - dbtype es como queda definido en la tabla, por ejemplo, varchar(20)
         * - realtype es el tipo resultado, por ejemplo varchar (sin el tamaño)
         * - generictype es uno de los índices de TYPE. P.E. autoincrement se cambiará por integer
         *
         */

        $column['type'] = $type;
        switch ($type) {
            case 'autoincrement':
            case 'relationship':
                $colType = self::DB_INDEX_TYPE;
                break;
            case 'boolean':
                $colType = 'tinyint(1) unsigned';
                break;
            default:
                $colType = $type;
        }

        $typeArray = static::splitType($colType);
        /**
         * ^ array:4 [▼
         *        "type" => "bigint"
         *        "length" => null
         *        "unsigned" => "yes"
         *        "zerofill" => "no"
         * ]
         */
        $type = $typeArray['type'];
        $length = $typeArray['length'] ?? $structure['length'];
        $unsigned = $typeArray['unsigned'] === 'yes';
        $zerofill = $typeArray['zerofill'] === 'yes';
        $genericType = static::getTypeOf($type);

        $column['dbtype'] = $colType;
        $column['realtype'] = $type;
        $column['generictype'] = $genericType;

        $column['null'] = 'YES';
        if ($structure['null'] && mb_strtolower($structure['null']) == 'no') {
            $column['null'] = 'NO';
        }

        if (empty($structure['default'])) {
            $column['default'] = null;
        } else {
            $column['default'] = (string) $structure['default'];
        }

        /**
         * Pueden existir otras definiciones de limitaciones físicas como min y max
         * De existir, tienen que ser contempladas en el método test y tener mayor peso que
         * la limitación en plantilla.
         */
        foreach (['min', 'max'] as $field) {
            if (isset($structure[$field])) {
                $column[$field] = (string) $structure[$field];
            }
        }

        if (isset($structure['comment'])) {
            $column['comentario'] = (string) $structure['comment'];
        }

        if (isset($structure['default'])) {
            $column['default'] = trim($structure['default'], " \"'`");
        }

        switch ($genericType) {
            case 'text':
                $column['dbtype'] = 'varchar(' . $length . ')';
                $column['maxlength'] = $length;
                break;
            case 'integer':
                /**
                 * Lo primero es ver la capacidad física máxima según el tipo de dato.
                 */
                $bytes = 4;
                switch ($type) {
                    case 'tinyint':
                        $bytes = 1;
                        break;
                    case 'smallint':
                        $bytes = 2;
                        break;
                    case 'mediumint':
                        $bytes = 3;
                        break;
                    case 'int':
                        $bytes = 4;
                        break;
                    case 'bigint':
                        $bytes = 8;
                        break;
                }
                $bits = 8 * (int) $bytes;
                $physicalMaxLength = 2 ** $bits;

                /**
                 * $minDataLength y $maxDataLength contendrán el mínimo y máximo valor que puede contener el campo.
                 */
                $minDataLength = $unsigned ? 0 : -$physicalMaxLength / 2;
                $maxDataLength = ($unsigned ? $physicalMaxLength : $physicalMaxLength / 2) - 1;

                /**
                 * De momento, se asignan los límites máximos por el tipo de dato.
                 * En $min y $max, iremos arrastrando los límites conforme se vayan comprobando.
                 * $min nunca podrá ser menor que $minDataLength.
                 * $max nunca podrá ser mayor que $maxDataLength.
                 */
                $min = $minDataLength;
                $max = $maxDataLength;

                /**
                 * Se puede hacer una limitación física Se puede haber definido en el xml un min y un max.
                 * A todos los efectos, lo definido en el XML como min o max se toma como limitación
                 * física del campo.
                 */
                if (isset($structure['min'])) {
                    $minXmlLength = $structure['min'];
                    if ($minXmlLength > $minDataLength) {
                        $min = $minXmlLength;
                    } else {
                        Debug::addMessage('messages', "({$key}): Se ha especificado un min {$minXmlLength} en el XML, pero por el tipo de datos, el mínimo es {$minDataLength}.");
                    }
                }
                if (isset($structure['max'])) {
                    $maxXmlLength = $structure['max'];
                    if ($maxXmlLength < $maxDataLength) {
                        $max = $maxXmlLength;
                    } else {
                        Debug::addMessage('messages', "({$key}): Se ha especificado un min {$maxXmlLength} en el XML, pero por el tipo de datos, el máximo es {$maxDataLength}.");
                    }
                }

                $column['min'] = $min;
                $column['max'] = $max;
                break;
            default:
                // ???
        }

        return $column;
    }

    /**
     * Create a table in the database.
     * Build the default fields, indexes and values defined in the model.
     *
     * @param string $tableName
     *
     * @return bool
     * @throws DebugBarException
     */
    public static function createTable(string $tableName): bool
    {
        $tabla = self::$bbddStructure[$tableName];
        $sql = self::createFields($tableName, $tabla['fields']);

        foreach ($tabla['keys'] as $name => $index) {
            $sql .= self::createIndex($tableName, $name, $index);
        }
        if (isset($tabla['values'])) {
            $sql .= self::setValues($tableName, $tabla['values']);
        }

        return Engine::exec($sql);
    }

    /**
     * Build the SQL statement to create the fields in the table.
     * It can also create the primary key if the auto_increment attribute is defined.
     *
     * @param string $tablename
     * @param array  $fieldList
     *
     * @return string
     */
    protected static function createFields(string $tablename, array $fieldList): string
    {
        $tablenameWithPrefix = Config::$dbPrefix . $tablename;

        $sql = "CREATE TABLE $tablenameWithPrefix ( ";
        foreach ($fieldList as $index => $col) {
            if (!isset($col['dbtype'])) {
                die('Tipo no especificado en createTable ' . $index);
            }

            $sql .= '`' . $index . '` ' . $col['dbtype'];
            $nulo = isset($col['null']) && $col['null'];

            $sql .= ($nulo ? '' : ' NOT') . ' NULL';

            if (isset($col['extra']) && (strtolower($col['extra']) == 'auto_increment')) {
                $sql .= ' PRIMARY KEY AUTO_INCREMENT';
            }

            $tmpDefecto = $col['default'] ?? null;
            $defecto = '';
            if (isset($tmpDefecto)) {
                if ($tmpDefecto == 'CURRENT_TIMESTAMP') {
                    $defecto = "$tmpDefecto";
                } else {
                    $defecto = "'$tmpDefecto'";
                }
            } else {
                if ($nulo) {
                    $defecto = 'NULL';
                }
            }

            if ($defecto != '') {
                $sql .= ' DEFAULT ' . $defecto;
            }

            $sql .= ', ';
        }
        $sql = substr($sql, 0, -2); // Quitamos la coma y el espacio del final
        $sql .= ') ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;' . self::CRLF;

        return $sql;
    }

    /**
     * Create the SQL statements for the construction of one index.
     * In the case of the primary index, it is not necessary if it is auto_increment.
     *
     * TODO:
     *
     * Moreover, it should not be defined if it is auto_increment because it would
     * generate an error when it already exists.
     *
     * @param string $tableName
     * @param string $indexname
     * @param array  $indexData
     *
     * @return string
     */
    protected static function createIndex($tableName, $indexname, $indexData)
    {
        $sql = "ALTER TABLE $tableName ADD CONSTRAINT $indexname ";

        $command = '';
        // https://www.w3schools.com/sql/sql_primarykey.asp
        // ALTER TABLE Persons ADD CONSTRAINT PK_Person PRIMARY KEY (ID,LastName);
        if (isset($indexData['PRIMARY'])) {
            $command = 'PRIMARY KEY ';
            $fields = $indexData['PRIMARY'];
        }

        // https://www.w3schools.com/sql/sql_create_index.asp
        // CREATE INDEX idx_pname ON Persons (LastName, FirstName);
        if (isset($indexData['INDEX'])) {
            $command = 'INDEX ';
            $fields = $indexData['INDEX'];
        }

        // https://www.w3schools.com/sql/sql_unique.asp
        // ALTER TABLE Persons ADD CONSTRAINT UC_Person UNIQUE (ID,LastName);
        if (isset($indexData['UNIQUE'])) {
            $command = 'UNIQUE INDEX ';
            $fields = $indexData['UNIQUE'];
        }

        if ($command == '') {
            // https://www.w3schools.com/sql/sql_foreignkey.asp
            // ALTER TABLE Orders ADD CONSTRAINT FK_PersonOrder FOREIGN KEY (PersonID) REFERENCES Persons(PersonID);
            if (isset($indexData['FOREIGN'])) {
                $command = 'FOREIGN KEY ';
                $foreignField = $indexData['FOREIGN'];
                if (isset($indexData['REFERENCES'])) {
                    $references = $indexData['REFERENCES'];
                    if (!is_array($references)) {
                        die('Esperaba un array en REFERENCES: ' . $tableName . '/' . $indexname);
                    }
                    if (count($references) != 1) {
                        die('Esperaba un array de 1 elemento en REFERENCES: ' . $tableName . '/' . $indexname);
                    }
                    $refTable = key($references);
                    $fields = '(' . implode(',', $references) . ')';
                } else {
                    die('FOREIGN necesita REFERENCES en ' . $tableName . '/' . $indexname);
                }

                $sql .= $command . ' ' . $foreignField . ' REFERENCES ' . $refTable . $fields;

                if (isset($indexData['ON']) && is_array($indexData['ON'])) {
                    foreach ($indexData['ON'] as $key => $value) {
                        $sql .= ' ON ' . $key . ' ' . $value . ', ';
                    }
                    $sql = substr($sql, 0, -2); // Quitamos el ', ' de detrás
                }
            }
        } else {
            if (is_array($fields)) {
                $fields = '(' . implode(',', $fields) . ')';
            } else {
                $fields = "($fields)";
            }

            if ($command == 'INDEX ') {
                $sql = "CREATE INDEX {$indexname} ON {$tableName}" . $fields;
            } else {
                $sql .= $command . ' ' . $fields;
            }
        }

        return $sql . ';' . self::CRLF;
    }

    /**
     * Create the SQL statements to fill the table with default data.
     *
     * @param string $tableName
     * @param array  $values
     *
     * @return string
     */
    protected static function setValues(string $tableName, array $values): string
    {
        $sql = "INSERT INTO $tableName ";
        $header = true;
        foreach ($values as $value) {
            $fields = "(";
            $datos = "(";
            foreach ($value as $fname => $fvalue) {
                $fields .= $fname . ", ";
                $datos .= "'$fvalue'" . ", ";
            }
            $fields = substr($fields, 0, -2) . ") ";
            $datos = substr($datos, 0, -2) . "), ";

            if ($header) {
                $sql .= $fields . " VALUES ";
                $header = false;
            }

            $sql .= $datos;
        }

        return substr($sql, 0, -2) . self::CRLF;
    }
}
