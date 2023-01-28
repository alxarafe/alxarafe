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

use Alxarafe\Core\Helpers\Dispatcher;
use Alxarafe\Core\Singletons\Config;
use Alxarafe\Core\Singletons\Debug;
use Alxarafe\Core\Singletons\FlashMessages;
use Alxarafe\Core\Singletons\Translator;
use Alxarafe\Core\Utils\MathUtils;
use DebugBar\DebugBarException;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Schema
 *
 * La clase abstracta Schema, define un esquema de base de datos teórico al que
 * se traduce la base de datos real y viceversa, de manera que el código sea
 * en la medida de lo posible, no dependiente de la base de datos real.
 *
 * TODO: ¿La información cacheada se procesa en YamlSchema o no merece la pena?
 *
 * @author  Rafael San José Tovar <info@rsanjoseo.com>
 * @version 2023.0101
 *
 * @package Alxarafe\Database
 */
class Schema
{
    /**
     * Tipo entero. Número sin decimales.
     */
    public const TYPE_INTEGER = 'integer';

    /**
     * Tipo real o coma flotante. Número con decimales. Puede dar problema con redondeos.
     */
    public const TYPE_FLOAT = 'float';

    /**
     * Tipo numérico de coma fija. Número con N decimales y precisión absoluta.
     * Es igual que un integer, pero se asume que un número determinado de dígitos son decimales.
     */
    public const TYPE_DECIMAL = 'decimal';

    /**
     * Tipo cadena de texto
     */
    public const TYPE_STRING = 'string';

    /**
     * Tipo bloque de texto
     */
    public const TYPE_TEXT = 'text';

    /**
     * Tipo fecha
     */
    public const TYPE_DATE = 'date';

    /**
     * Tipo hora
     */
    public const TYPE_TIME = 'time';

    /**
     * Tipo fecha + hora.
     * TODO: Hay que revisar el tema de la zona horaria.
     *       De lógica, siempre se debe de almacenar como UTC y convertir al guardar y leer.
     */
    public const TYPE_DATETIME = 'datetime';

    /**
     * Tipo lógico: TRUE o FALSE.
     */
    public const TYPE_BOOLEAN = 'bool';

    /**
     * Longitud de un string si no se ha detallado ninguna
     */
    public const DEFAULT_STRING_LENGTH = 50;

    /**
     * Bytes que usará un integer si no se ha detallado tamaño
     */
    public const DEFAULT_INTEGER_SIZE = 4;

    /**
     * Si un integer usa signo por defecto o no. True si no utiliza signo por defecto.
     */
    public const DEFAULT_INTEGER_UNSIGNED = true;

    /**
     * Retorno de carro y salto de línea
     */
    const CRLF = "\r\n";

    /**
     * Contiene la definición ampliada de la estructura de la base de datos.
     *
     * @var array
     */
    public static array $bbddStructure;

    /**
     * Realiza una comprobación integral de la base de datos, verificando que la configuración
     * indicada en los archivos yaml de configuración de tablas, se corresponde con lo
     * creado en la base de datos.
     * Adecúa la base de datos a la información facilitada por los archivos yaml.
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @throws DebugBarException
     */
    public static function checkDatabaseStructure()
    {
        //        DB::$engine->exec('DROP TABLE IF EXISTS `tc_users`;');
        //        DB::$engine->exec('DROP TABLE IF EXISTS `tc_menus`;');
        //        DB::$engine->exec('DROP TABLE IF EXISTS `tc_portfolio_assets`;');

        foreach (YamlSchema::getTables() as $key => $table) {
            if (!file_exists($table)) {
                Debug::message('No existe la tabla ' . $table);
            }
            Debug::message("Verificando la tabla $key, definida en $table.");
            if (!static::checkStructure($key, $table)) {
                FlashMessages::setError('Error al comprobar la estructura de la tabla ' . $table);
            }
        }
    }

    private static function getGenericType(array $data): array
    {
        $result = [];
        $type = $data['type'];

        switch ($type) {
            case 'autoincrement':
                $result['nullable'] = 'no';
            case 'relationship':
                $type = Schema::TYPE_INTEGER;
                $result['size'] = 8;
                break;
        }

        // Si es un tipo genérico, se retorna automáticamente.
        if (isset(DB::$helper::$types[$type])) {
            $result['generictype'] = $type;
            return $result;
        }

        foreach (DB::$helper::$types as $key => $types) {
            if (in_array($type, $types)) {
                $result['generictype'] = $key;
                return $result;
            }
        }

        Debug::message("No se ha encontrado genérico para {$type}. Se asume 'string'.");
        $result['generictype'] = 'string';
        return $result;
    }

    private static function yamlFieldAnyToSchema(string $genericType, array $data): array
    {
        $types = DB::$helper::getDataTypes();
        $type = $types[$genericType];
        $result = [];
        $result['generictype'] = $genericType;
        $result['dbtype'] = reset($type);
        return $result;
    }

    /**
     * Cumplimenta los datos faltantes del yaml de definición al de caché para
     * tipos enteros.
     * Posibles valores que se pueden recibir en $data:
     * - min, es el valor mínimo aceptado por el entero.
     * - max, es el valor máximo aceptado por el entero.
     * - size, es el número de bytes que ocupa el entero.
     * - unsigned, indica si necesita signo o no.
     * La respuesta puede modificar algunos de esos valores.
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @param array $data
     *
     * @return array
     */
    private static function yamlFieldIntegerToSchema(array $data): array
    {
        $min = $data['min'] ?? null;
        $max = $data['max'] ?? null;

        // Si hay mínimo y máximo, se ajusta el resto de parámetros a esos datos.
        if ($min !== null && $max !== null) {
            $unsigned = $min >= 0;
            $size = MathUtils::howManyBytes($max, $min, $unsigned);
            $extra = DB::$helper::getIntegerMinMax($size, $unsigned);
            return [
                'dbtype' => $extra['dbtype'],
                'min' => $min,
                'max' => $max,
                'size' => $extra['size'],
                'unsigned' => $extra['unsigned'],
            ];
        }

        // Si tenemos máximo, pero no tenemos mínimo, se ajusta al máximo y se toma signo por defecto
        if ($max !== null) {
            $unsigned = $data['unsigned'] ?? self::DEFAULT_INTEGER_UNSIGNED;
            $size = MathUtils::howManyBytes($max);
            $extra = DB::$helper::getIntegerMinMax($size, $unsigned);
            return [
                'dbtype' => $extra['dbtype'],
                'min' => $extra['min'],
                'max' => $max,
                'size' => $extra['size'],
                'unsigned' => $extra['unsigned'],
            ];
        }

        // Si lo que no tenemos es máximo, ajustamos el tamaño al mínimo y se ajusta el signo al mínimo
        if ($min !== null) {
            $unsigned = $min >= 0;
            $size = MathUtils::howManyBytes($min, $min, $unsigned);
            $extra = DB::$helper::getIntegerMinMax($size, $unsigned);
            return [
                'dbtype' => $extra['dbtype'],
                'min' => 0, // TODO: Si unsigned, será el menor entero negativo.
                'max' => $max,
                'size' => $extra['size'],
                'unsigned' => $extra['unsigned'],
            ];
        }

        // Mínimo y máximo son nulos
        $size = $data['size'] ?? self::DEFAULT_INTEGER_SIZE;
        $unsigned = $data['unsigned'] ?? self::DEFAULT_INTEGER_UNSIGNED;
        return DB::$helper::getIntegerMinMax($size, $unsigned);
    }

    private static function yamlFieldStringToSchema(array $data): array
    {
        return [
            'dbtype' => 'varchar',
            'minlength' => $data['minlength'] ?? 0,
            'length' => $data['length'] ?? self::DEFAULT_STRING_LENGTH,
        ];
    }

    /**
     * Tomando la definición de un campo de una tabla en un archivo yaml de definición,
     * genera toda la información necesaria para la creación, actualización de la tabla
     * y el mantenimiento de los datos del campo.
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @param array $data
     *
     * @return array
     */
    public static function yamlFieldToSchema(array $data): array
    {
        /**
         * Los datos que vienen del yaml son los siguientes:
         * - name es el nombre del campo
         * - type es el tipo genérico del campo
         * El resto, será dependiente del tipo genérico de dato.
         * Puede ocurrir que no venga un tipo genérico, sino uno fijo, en ese caso
         * se intentará corregir, pero se notificará en la barra de depuración.
         * Si hay error en la conversión, se generará un error.
         */
        $column = [];
        $column['name'] = (string) $data['name'];
        $column['type'] = (string) $data['type'];
        $column['nullable'] = $data['nullable'] ?? 'yes';
        $column['default'] = $data['default'] ?? null;
        $column = array_merge($column, self::getGenericType($data));

        switch ($column['generictype']) {
            case Schema::TYPE_INTEGER:
                foreach (['min', 'max', 'unsigned', 'size'] as $field) {
                    if (isset($data[$field])) {
                        $column[$field] = $data[$field];
                        unset($data[$field]);
                    }
                }
                $result = self::yamlFieldIntegerToSchema($column);
                break;
            case Schema::TYPE_STRING:
                foreach (['minlength', 'length'] as $field) {
                    if (isset($data[$field])) {
                        $column[$field] = $data[$field];
                        unset($data[$field]);
                    }
                }
                $result = self::yamlFieldStringToSchema($column);
                break;
            case Schema::TYPE_FLOAT:
            case Schema::TYPE_DECIMAL:
            case Schema::TYPE_TEXT:
            case Schema::TYPE_DATE:
            case Schema::TYPE_TIME:
            case Schema::TYPE_DATETIME:
            case Schema::TYPE_BOOLEAN:
                $result = self::yamlFieldAnyToSchema($column['generictype'], $column);
                break;
            default:
                $result = self::yamlFieldAnyToSchema($column['generictype'], $column);
        }

        unset($data['name']);
        unset($data['type']);
        unset($data['default']);
        unset($data['nullable']);

        $column = array_merge($column, $result);

        if (count($data) > 0) {
            dump(['Ignorado en data' => $data]);
        }
        return $column;
    }

    private static function checkTable(string $tableName, string $path, bool $create = true): array
    {
        $yaml = Yaml::parseFile($path);
        $fields = $yaml['fields'] ?? [];

        $data = [];
        foreach ($fields as $key => $field) {
            $field['name'] = $key;
            $schema = Schema::yamlFieldToSchema($field);
            $data['yamldef'][$key] = $field;
            $data['schema'][$key] = $schema;
            $data['db'][$key] = DB::$helper::yamlFieldToDb($schema);
        }

        $indexes = $yaml['indexes'] ?? [];

        return [
            'fields' => $data,
            'indexes' => $indexes,
        ];
    }

    /**
     * Comprueba la estructura de la tabla y la crea si no existe y así se solicita.
     * Si los datos de la estructura no están en la caché, los regenera y almacena.
     * Al regenerar los datos para la caché, también realiza una verificación de
     * la estructura por si hay cambios que aplicar en la misma.
     *
     * TODO: Es mejor que haya un checkStructure que genere TODAS las tablas e índices
     * Ese checkstructure se debe de generar tras limpiar caché.
     * La caché deberá de limpiarse cada vez que se active o desactive un módulo.
     * El último paso de la generación de tablas, sería comprobar las dependencias
     * de tablas para saber cuántas tablas usan una constraint de cada tabla para poder
     * realizar cambios en la base de datos y tener una visión más nítida de la misma en
     * cualquier momento, si bien, esa estructura no será clara hasta que no se hayan leído
     * todas, y si hay un cambio entre medias, pues igual la única solución viable es
     * determinarlo por la propia base de datos.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0105
     *
     * @param string $tableName
     * @param string $path
     * @param bool   $create
     *
     * @return bool
     * @throws DebugBarException
     */
    private static function checkStructure(string $tableName, string $path, bool $create = true): bool
    {
        // Si el dato ya ha sido cargado, retornamos porque no hay nada que hacer.
        if (!empty(self::$bbddStructure[$tableName])) {
            return true;
        }

        // Si no está, pero está cacheado, se recupera de la caché y se retorna.
        self::$bbddStructure[$tableName] = YamlSchema::loadCacheYamlFile(YamlSchema::YAML_CACHE_TABLES_DIR, $tableName);
        if (!empty(self::$bbddStructure[$tableName])) {
            return true;
        }

        // Si no está cacheado, entonces hay que comprobar si hay cambios en la estructura y regenerarla.
        self::$bbddStructure[$tableName] = self::checkTable($tableName, $path, $create);

        if (DB::tableExists($tableName)) {
            Debug::message('La tabla ' . $tableName . ' existe');
            if (!self::updateTable($tableName)) {
                FlashMessages::setError(Translator::trans('table_creation_error', ['%tablename%' => $tableName]));
            }
        } else {
            Debug::message('La tabla ' . $tableName . ' NO existe');
            if (!self::createTable($tableName)) {
                FlashMessages::setError(Translator::trans('table_creation_error', ['%tablename%' => $tableName]));
            }
        }

        if (!YamlSchema::saveCacheYamlFile(YamlSchema::YAML_CACHE_TABLES_DIR, $tableName, self::$bbddStructure[$tableName])) {
            Debug::message('No se ha podido guardar la información de caché para la tabla ' . $tableName);
            return false;
        }
        return true;
    }

    /**
     * Obtiene el tipo genérico del tipo de dato que se le ha pasado.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0101
     *
     * @param string $type
     *
     * @return string
     */
    public static function _getTypeOf(string $type): string
    {
        foreach (DB::getDataTypes() as $index => $types) {
            if (in_array(strtolower($type), $types)) {
                return $index;
            }
        }
        Debug::message($type . ' not found in DBSchema::getTypeOf()');
        return 'text';
    }

    private static function _splitType(string $originalType): array
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
            Debug::message("XML: Uso de '{$originalType}' en lugar de '{$modifiedType}'.");
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

    private static function _getSeed($tableName): string
    {
        $tableNameWithPrefix = DB::$dbPrefix . $tableName;

        $seeds = Dispatcher::getFiles('Seeds', 'csv');

        if (!isset($seeds[$tableName])) {
            return '';
        }

        $filename = $seeds[$tableName];
        if (!file_exists($filename)) {
            return '';
        }

        $rows = 10; // Indicamos el número de registros que vamos a insertar de una vez
        $handle = fopen($filename, "r");
        if ($handle === false) {
            FlashMessages::addError('No ha sido posible abrir el archivo ' . $filename);
            return '';
        }

        // Asumimos que la primera fila es la cabecera...
        $header = fgetcsv($handle, 0, ';');
        if ($header === false) {
            FlashMessages::addError('No ha sido posible leer la primera línea del archivo ' . $filename);
            fclose($handle);
            return '';
        }

        $sqlHeader = "INSERT INTO `{$tableNameWithPrefix}` (`" . implode('`, `', $header) . '`) VALUES ';
        $row = 0;
        $sqlData = [];
        while (($data = fgetcsv($handle, 0, ';')) !== false) {
            // Entrecomillamos lo que no sea null.
            foreach ($data as $key => $datum) {
                if (mb_strtoupper($datum) !== 'NULL') {
                    $data[$key] = "'$datum'";
                }
            }

            if ($row % $rows === 0) {
                if (count($sqlData) > 0) {
                    $result .= ($sqlHeader . implode(', ', $sqlData) . ';' . PHP_EOL);
                }
                $sqlData = [];
            }
            $sqlData[] = '(' . implode(', ', $data) . ')';
            $row++;
        }
        if (count($sqlData) > 0) {
            $result .= ($sqlHeader . implode(', ', $sqlData) . ';' . PHP_EOL);
        }
        fclose($handle);

        return $result;
    }

    private static function _updateField(string $tableName, string $fieldName, array $structure): string
    {
        dump([
            'tablename' => $tableName,
            'fieldname' => $fieldName,
            'new structure' => self::$bbddStructure[$tableName]['fields'][$fieldName],
            'structure' => $structure,
        ]);
        return '';
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
    private static function createTable(string $tableName): bool
    {
        $tabla = self::$bbddStructure[$tableName];
        $sql = self::createFields($tableName, $tabla['fields']['db']);

        /*
        foreach ($tabla['indexes'] as $name => $index) {
            $sql .= self::createIndex($tableName, $name, $index);
        }

        if (isset($tabla['values'])) {
            $sql .= self::setValues($tableName, $tabla['values']);
        } else {
            $sql .= self::getSeed($tableName);
        }
        */

        return Engine::exec($sql);
    }

    private static function updateTable(string $tableName): bool
    {
        $yamlStructure = self::$bbddStructure[$tableName];
        $dbStructure = DB::getColumns($tableName);

        $changes = [];
        foreach ($yamlStructure['fields']['db'] as $field => $newStructure) {
            $oldStructure = DB::$helper::sanitizeDbStructure($yamlStructure['fields']['schema'][$field]['generictype'], $dbStructure[$field]);
            $dif = array_diff($oldStructure, $newStructure);
            if (count($dif) > 0) {
                $changes[] = DB::modify($tableName, $oldStructure, $newStructure);
            }
        }

        if (empty($changes)) {
            return true;
        }

        $result = true;
        foreach ($changes as $change) {
            $result = $result && Engine::exec($change);
        }
        return $result;
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
    protected static function _createFields(string $tablename, array $fieldList): string
    {
        $tablenameWithPrefix = DB::$dbPrefix . $tablename;

        $sql = "CREATE TABLE $tablenameWithPrefix ( ";
        foreach ($fieldList as $index => $column) {
            $col = $column['schema'];
            if (!isset($col['dbtype'])) {
                die('Tipo no especificado en createTable ' . $index);
            }

            $sql .= '`' . $index . '` ' . $col['dbtype'];
            $nulo = isset($col['null']) && $col['null'];

            if (strtolower($col['type']) === 'autoincrement') {
                $nulo = false;
                $sql .= ' PRIMARY KEY AUTO_INCREMENT';
            }

            $sql .= ($nulo ? '' : ' NOT') . ' NULL';

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

    protected static function createFields(string $tablename, array $fieldList): string
    {
        $tablenameWithPrefix = DB::$dbPrefix . $tablename;

        $sql = "CREATE TABLE $tablenameWithPrefix ( ";
        foreach ($fieldList as $column) {
            $sql .= DB::$helper::getSqlField($column) . ', ';
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
    protected static function _createIndex($tableName, $indexname, $indexData)
    {
        $tableNameWithPrefix = DB::$dbPrefix . $tableName;

        $sql = "ALTER TABLE $tableNameWithPrefix ADD CONSTRAINT $indexname ";

        $command = '';
        // https://www.w3schools.com/sql/sql_primarykey.asp
        // ALTER TABLE Persons ADD CONSTRAINT PK_Person PRIMARY KEY (ID,LastName);
        if (isset($indexData['primary'])) {
            $command = 'PRIMARY KEY ';
            $fields = $indexData['primary'];
        }

        // https://www.w3schools.com/sql/sql_create_index.asp
        // CREATE INDEX idx_pname ON Persons (LastName, FirstName);
        if (isset($indexData['index'])) {
            $command = 'INDEX ';
            $fields = $indexData['index'];
        }

        // https://www.w3schools.com/sql/sql_unique.asp
        // ALTER TABLE Persons ADD CONSTRAINT UC_Person UNIQUE (ID,LastName);
        if (isset($indexData['unique'])) {
            $command = 'UNIQUE INDEX ';
            $fields = $indexData['column'];
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
                        die('Esperaba un array en REFERENCES: ' . $tableNameWithPrefix . '/' . $indexname);
                    }
                    if (count($references) != 1) {
                        die('Esperaba un array de 1 elemento en REFERENCES: ' . $tableNameWithPrefix . '/' . $indexname);
                    }
                    $refTable = key($references);
                    $fields = '(' . implode(',', $references) . ')';
                } else {
                    die('FOREIGN necesita REFERENCES en ' . $tableNameWithPrefix . '/' . $indexname);
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
                $sql = "CREATE INDEX {$indexname} ON {$tableNameWithPrefix}" . $fields;
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
    protected static function _setValues(string $tableName, array $values): string
    {
        $tablenameWithPrefix = DB::$dbPrefix . $tableName;

        $sql = "INSERT INTO $tablenameWithPrefix ";
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

    /**
     * Return true if $tableName exists in database
     *
     * @param string $tableName
     *
     * @return bool
     * @throws DebugBarException
     */
    public static function _tableExists($tableName): bool
    {
        $tableNameWithPrefix = DB::$dbPrefix . $tableName;
        $dbName = DB::$dbName;
        $sql = "SELECT COUNT(*) AS Total FROM information_schema.tables WHERE table_schema = '{$dbName}' AND table_name='{$tableNameWithPrefix}'";

        $data = Engine::select($sql);
        $result = reset($data);

        return $result['Total'] === '1';
    }

    private static function _getFieldsAndIndexes($tableName, $path): array
    {
        $data = Yaml::parseFile($path);

        $result = [];
        foreach ($data['fields'] ?? [] as $key => $datum) {
            $datum['key'] = $key;
            $result['fields'][$key]['db'] = DB::normalizeFromYaml($datum);
            $result['fields'][$key]['info'] = Schema::normalize($datum);
            if ($result['fields'][$key]['type'] === 'autoincrement') {
                // TODO: Ver cómo tendría que ser la primary key
                $result['indexes']['primary'] = $key;
            }
        }
        foreach ($data['indexes'] ?? [] as $key => $datum) {
            $datum['key'] = $key;
            $result['indexes'][$key] = $datum;
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

    private static function _getFields($tableName): array
    {
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

    private static function _getIndexes($tableName): array
    {
        $result = [];
        return $result;
    }

    private static function _getRelated($tableName): array
    {
        $result = [];
        return $result;
    }
}
