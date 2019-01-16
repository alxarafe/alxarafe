<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Helpers;

use Exception;
use Symfony\Component\Yaml\Yaml;

/**
 * The Schema class contains static methods that allow you to manipulate the
 * database. It is used to create and modify tables and indexes in the database.
 */
class Schema
{

    /**
     * TODO: Undocummented
     */
    const CRLF = "\n\t";

    /**
     * TODO: Undocummented
     *
     * @var
     */
    static protected $databaseStructure;

    /**
     * TODO: Undocummented
     *
     * @var
     */
    static protected $SqlHelper;

    /**
     * TODO: Undocummented
     *
     * @var
     */
    protected $model;

    /**
     * TODO: Undocummented
     *
     * @var
     */
    protected $tableName;

    /**
     * TODO: Undocummented
     *
     * @var
     */
    protected $structure;

    /**
     * TODO: Undocummented
     */
    public static function saveStructure(): void
    {
        $folder = constant('BASE_PATH') . '/schema';
        if (!is_dir($folder)) {
            mkdir($folder);
        }
        if (is_dir($folder)) {
            $tables = Config::$sqlHelper->getTables();
            foreach ($tables as $table) {
                $filename = $folder . '/' . $table . '.yaml';
                $data = Config::$dbEngine->getStructure($table);
                file_put_contents($filename, YAML::dump($data));
            }
        }
    }

    /**
     * Return true if $tableName exists in database
     *
     * @param string $tableName
     *
     * @return bool
     */
    public static function tableExists($tableName): bool
    {
        $tableName = Config::getVar('dbPrefix') . $tableName;
        $sql = 'SELECT 1 FROM ' . $tableName . ';';
        return (bool) Config::$dbEngine->exec($sql);
    }

    /**
     * TODO: Undocumentend
     *
     * @return array
     */
    public static function getTables(): array
    {
        $queries = Config::$sqlHelper->getTables();
        $queryResult = [];
        foreach ($queries as $query) {
            $queryResult[] = Config::$dbEngine->select($query);
        }
        return Utils::flatArray($queryResult);
    }

    /**
     * TODO: Undocumented
     *
     * @param string $tableName
     *
     * @return array
     */
    public static function getStructure(string $tableName): array
    {
        return Config::$dbEngine->getStructure($tableName);
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
        $ret = [];
        $ret['keys'] = $structure['keys'] ?? [];
        $ret['values'] = $structure['values'] ?? [];
        foreach ($structure['fields'] as $key => $value) {
            $ret['fields'][$key] = self::normalizeField($tableName, $key, $value);
        }
        return $ret;
    }

    /**
     * @param string $tableName
     * @param string $field
     * @param array  $structure
     *
     * @return array|null
     */
    static protected function normalizeField(string $tableName, string $field, array $structure): ?array
    {
        if (!isset($structure['type'])) {
            Debug::testArray("The type parameter is mandatory in {$field}. Error in table " . $tableName, $structure);
        }

        $dbType = $structure['type'];
        if (!in_array($structure['type'], ['integer', 'decimal', 'string', 'float', 'date', 'datetime'])) {
            $msg = "<p>Check Schema.normalizeField if you think that {$dbType} might be necessary.</p>";
            $msg .= "<p>Type {$dbType} is not valid for field {$field} of table {$tableName}</p>";
            $e = new Exception($msg);
            Debug::addException($e);
            return null;
        }

        // TODO: The assignments are dead and can be removed.
        $min = $structure['min'] ?? 0;
        $max = $structure['max'] ?? 0;
        $default = $structure['default'] ?? null;
        $label = $structure['label'] ?? $tableName . '-' . $field;
        $unsigned = (!isset($structure['unsigned']) || $structure['unsigned'] == true);
        $null = ((isset($structure['null'])) && $structure['null'] == true);

        return $structure;
        /*
        $ret = [];
        if ($type == 'string') {
            if ($max == 0) {
                $max = constant(DEFAULT_STRING_LENGTH);
            }
            $dbType = "$dbType($max)";
            $ret['pattern'] = '.{' . $min . ',' . $max . '}';
        } else {
            if ($type == 'number') {
                if ($default === true) {
                    $default = '1';
                }
                if ($max == 0) {
                    $_length = constant(DEFAULT_INTEGER_SIZE);
                    $max = pow(10, $_length) - 1;
                } else {
                    $_length = strlen($max);
                }

                if ($min == 0) {
                    $min = $unsigned ? 0 : -$max;
                } else {
                    if ($_length < strlen($min)) {
                        $_length = strlen($min);
                    }
                }

                if (isset($structure['decimals'])) {
                    $decimales = $structure['decimals'];
                    $precision = pow(10, -$decimales);
                    $_length += $decimales;
                    $dbType = "decimal($_length,$decimales)" . ($unsigned ? ' unsigned' : '');
                    $ret['min'] = $min == 0 ? 0 : ($min < 0 ? $min - 1 + $precision : $min + 1 - $precision);
                    $ret['max'] = $max > 0 ? $max + 1 - $precision : $max - 1 + $precision;
                } else {
                    $precision = null;
                    $dbType = "integer($_length)" . ($unsigned ? ' unsigned' : '');
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
        */
    }

    /**
     * Create a table in the database.
     * Build the default fields, indexes and values defined in the model.
     *
     * @param string $tableName
     *
     * @return bool
     */
    public static function createTable(string $tableName): bool
    {
        $tabla = Config::$bbddStructure[$tableName];
        $sql = self::createFields($tableName, $tabla['fields']);

        foreach ($tabla['keys'] as $name => $index) {
            $sql .= self::createIndex($tableName, $name, $index);
        }
        $sql .= self::setValues($tableName, $tabla['values']);
        return Config::$dbEngine->exec($sql);
    }

    /**
     * Build the SQL statement to create the fields in the table.
     * It can also create the primary key if the auto_increment attribute is defined.
     *
     * @param string $tableName
     * @param array  $fieldList
     *
     * @return string|null
     */
    static protected function createFields(string $tableName, array $fieldList): ?string
    {
        $tableName = Config::getVar('dbPrefix') . $tableName;
        $sql = "CREATE TABLE $tableName ( ";
        foreach ($fieldList as $index => $col) {
            if (!isset($col['dbtype'])) {
                $msg = 'Tipo no especificado en createTable';
                $e = new Exception($msg);
                Debug::addException($e);
                return null;
            }

            $sql .= '`' . $index . '` ' . $col['dbtype'];
            $nulo = isset($col['null']) && $col['null'];

            $sql .= ($nulo ? '' : ' NOT') . ' NULL';

            if (isset($col['extra']) && (strtolower($col['extra']) == 'auto_increment')) {
                $sql .= ' PRIMARY KEY AUTO_INCREMENT';
            }

            $_defecto = $col['default'] ?? null;
            $defecto = '';
            if (isset($_defecto)) {
                if ($_defecto == 'CURRENT_TIMESTAMP') {
                    $defecto = "$_defecto";
                } else {
                    $defecto = "'$_defecto'";
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
     * @return string|null
     */
    static protected function createIndex(string $tableName, string $indexname, array $indexData): ?string
    {
        $fields = '';
        $tableName = Config::getVar('dbPrefix') . $tableName;
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
                        $msg = 'Esperaba un array en REFERENCES: ' . $tableName . '/' . $indexname;
                        $e = new Exception($msg);
                        Debug::addException($e);
                        return null;
                    }
                    if (count($references) != 1) {
                        $msg = 'Esperaba un array de 1 elemento en REFERENCES: ' . $tableName . '/' . $indexname;
                        $e = new Exception($msg);
                        Debug::addException($e);
                        return null;
                    }
                    $refTable = key($references);
                    $fields = '(' . implode(',', $references) . ')';
                } else {
                    $msg = 'FOREIGN necesita REFERENCES en ' . $tableName . '/' . $indexname;
                    $e = new Exception($msg);
                    Debug::addException($e);
                    return null;
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
    static protected function setValues(string $tableName, array $values): string
    {
        $tableName = Config::getVar('dbPrefix') . $tableName;
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
     * @return array|null
     */
    static protected function old_normalizeField(string $tableName, string $field, array $structure): ?array
    {
        if (!isset($structure['type'])) {
            Debug::testArray("The type parameter is mandatory in {$field}. Error in table " . $tableName, $structure);
        }

        $dbType = $structure['type'];

        if ($dbType == 'boolean') {
            $dbType = 'tinyint';
            $structure['min'] = 0;
            $structure['max'] = 1;
        }

        switch ($dbType) {
            case 'int':
            case 'tinyint':
            case 'number':
                $type = 'number';
                break;
            case 'float':
                $type = 'float';
                break;
            case 'double':
                $type = 'double';
                break;
            case 'char':
            case 'varchar':
            case 'text':
                $type = 'text';
                break;
            case 'date':
                $type = 'date';
                break;
            case 'datetime':
            case 'timestamp':
                $type = 'datetime-local';
                break;
            default:
                $msg = "<p>Check Schema.normalizeField if you think that {$dbType} might be necessary.</p>";
                $msg .= "<p>Type {$dbType} is not valid for field {$field} of table {$tableName}.</p>";
                $e = new Exception($msg);
                Debug::addException($e);
                return null;
        }

        $min = $structure['min'] ?? 0;
        $max = $structure['max'] ?? 0;
        $default = $structure['default'] ?? null;
        $label = $structure['label'] ?? $field;
        $unsigned = (!isset($structure['unsigned']) || $structure['unsigned'] == true);
        $null = ((isset($structure['null'])) && $structure['null'] == true);

        $ret = [];
        if ($type == 'text') {
            if ($max == 0) {
                $max = constant(DEFAULT_STRING_LENGTH);
            }
            $dbType = "$dbType($max)";
            $ret['pattern'] = '.{' . $min . ',' . $max . '}';
        } elseif ($type == 'number') {
            if ($default === true) {
                $default = '1';
            }

            $_length = strlen($max);
            if ($max == 0) {
                $_length = constant(DEFAULT_INTEGER_SIZE);
                $max = pow(10, $_length) - 1;
            }

            if ($min == 0) {
                $min = $unsigned ? 0 : -$max;
            } elseif ($_length < strlen($min)) {
                $_length = strlen($min);
            }

            $precision = null;
            $dbType = "integer($_length)" . ($unsigned ? ' unsigned' : '');
            $ret['min'] = $min;
            $ret['max'] = $max;
            if (isset($structure['decimals'])) {
                $decimales = $structure['decimals'];
                $precision = pow(10, -$decimales);
                $_length += $decimales;
                $dbType = "decimal($_length,$decimales)" . ($unsigned ? ' unsigned' : '');
                $ret['min'] = $min == 0 ? 0 : ($min < 0 ? $min - 1 + $precision : $min + 1 - $precision);
                $ret['max'] = $max > 0 ? $max + 1 - $precision : $max - 1 + $precision;
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
}
