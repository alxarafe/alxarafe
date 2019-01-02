<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Helpers;

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
    protected $tablename;
    /**
     * TODO: Undocummented
     *
     * @var
     */
    protected $structure;

    /**
     * Flatten an array to leave it at a single level.
     * Ignore the value of the indexes of the array, taking only the values.
     * Remove spaces from the result and convert it to lowercase.
     *
     * @param array $array
     * @return array
     */
    static protected function flatArray(array $array): array
    {
        $ret = [];
        foreach ($array as $value) {
            if (is_array($value)) {
                // We expect that the indexes will not overlap
                $ret = array_merge($ret, self::flatArray($value));
            } else {
                $ret[] = strtolower(trim($value));
            }
        }
        return $ret;
    }

    /**
     * TODO: Undocummented
     */
    static function saveStructure()
    {
        $folder = BASE_PATH . '/schema';
        if (!is_dir($folder)) {
            mkdir($folder);
        }
        if (is_dir($folder)) {
            $tables = self::getTables();
            foreach ($tables as $table) {
                $filename = $folder . '/' . $table . '.yaml';
                $data = self::getColumns($table);
                file_put_contents($filename, YAML::dump($data));
            }
        }
    }

    /**
     * Return true if $tablename exists in database
     * 
     * @param string $tablename
     * @return bool
     */
    static function tableExists($tablename): bool
    {
        return (bool) Config::$dbEngine->exec('SELECT 1 FROM ' . $tablename);
    }

    /**
     * @return array
     */
    static function getTables(): array
    {
        $query = Config::$sqlHelper->getTables();
        return self::flatArray(Config::$dbEngine->select($query));
    }

    /**
     * @param string $tablename
     *
     * @return array
     */
    static function getColumns(string $tablename): array
    {
        return Config::$dbEngine->getColumns($tablename);
    }

    /**
     * Take the definition of a field, and make sure you have all the information
     * that is necessary for its creation or maintenance, calculating the missing
     * data if possible.
     * It can cause an exception if some vital data is missing, but this should
     * only occur at the design stage.
     *
     * @param string $tablename
     * @param string $field
     * @param array $structure
     * @return array
     */
    static protected function normalizeField(string $tablename, string $field, array $structure): array
    {
        if (!isset($structure['type'])) {
            Debug::testArray("The type parameter is mandatory in {$field}. Error in table " . $tablename, $structure);
        }

        $dbtype = $structure['type'];

        if ($dbtype == 'boolean') {
            $dbtype = 'tinyint';
            $structure['min'] = 0;
            $structure['max'] = 1;
        }

        if ($dbtype == 'int' || $dbtype == 'tinyint' || $dbtype == 'number') {
            $type = 'number';
        } else if ($dbtype == 'float') {
            $type = 'float';
        } else if ($dbtype == 'double') {
            $type = 'double';
        } else if ($dbtype == 'char' || $dbtype == 'varchar' || $dbtype == 'text') {
            $type = 'text';
        } else if ($dbtype == 'date') {
            $type = 'date';
        } else if ($dbtype == 'datetime' || $dbtype == 'timestamp') {
            $type = 'datetime-local';
        } else {
            echo "<p>Check Schema.normalizeField if you think that {$dbtype} might be necessary.</p>";
            die("Type {$dbtype} is not valid for field {$field} of table {$tablename}");
        }

        $min = (isset($structure['min'])) ? $structure['min'] : 0;
        $max = (isset($structure['max'])) ? $structure['max'] : 0;
        $default = (isset($structure['default'])) ? $structure['default'] : Null;
        $label = (isset($structure['label'])) ? $structure['label'] : $field;
        $unsigned = (!isset($structure['unsigned']) || $structure['unsigned'] == true);
        $null = ((isset($structure['null'])) && $structure['null'] == true);

        if ($type == 'text') {
            if ($max == 0) {
                $max = DEFAULT_STRING_LENGTH;
            }
            $dbtype = "$dbtype($max)";
            $ret['pattern'] = '.{' . $min . ',' . $max . '}';
        } else if ($type == 'number') {
            if ($default === true) {
                $default = '1';
            }
            if ($max == 0) {
                $_length = DEFAULT_INTEGER_SIZE;
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
                $dbtype = "decimal($_length,$decimales)" . ($unsigned ? ' unsigned' : '');
                $ret['min'] = $min == 0 ? 0 : ($min < 0 ? $min - 1 + $precision : $min + 1 - $precision);
                $ret['max'] = $max > 0 ? $max + 1 - $precision : $max - 1 + $precision;
            } else {
                $precision = null;
                $dbtype = "integer($_length)" . ($unsigned ? ' unsigned' : '');
                $ret['min'] = $min;
                $ret['max'] = $max;
            }
        }

        $ret['type'] = $type;
        $ret['dbtype'] = $dbtype;
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
            $ret['relation'] = array(
                'table' => $structure['relations'][$field]['table'],
                'id' => isset($structure['relations'][$field]['id']) ? $structure['relations'][$field]['id'] : 'id',
                'name' => isset($structure['relations'][$field]['name']) ? $structure['relations'][$field]['name'] : 'name',
            );
        }

        return $ret;
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
     * @param array $structure
     * @param string $tablename
     * @return array
     */
    static function setNormalizedStructure(array $structure, string $tablename): array
    {
        $ret['keys'] = $structure['keys'] ?? [];
        $ret['values'] = $structure['values'] ?? [];
        foreach ($structure['fields'] as $key => $value) {
            $ret['fields'][$key] = self::normalizeField($tablename, $key, $value);
        }
        return $ret;
    }

    /**
     * Build the SQL statement to create the fields in the table.
     * It can also create the primary key if the auto_increment attribute is defined.
     *
     * @param string $fieldName
     * @param array $fieldList
     * @return string
     */
    static protected function createFields(string $fieldName, array $fieldList): string
    {
        $consulta = "CREATE TABLE $fieldName ( ";
        foreach ($fieldList as $index => $col) {
            if (!isset($col['dbtype'])) {
                die('Tipo no especificado en createTable');
            }

            $consulta .= '`' . $index . '` ' . $col['dbtype'];
            $nulo = isset($col['null']) && $col['null'];

            $consulta .= ($nulo ? '' : ' NOT') . ' NULL';

            if (isset($col['extra']) && (strtolower($col['extra']) == 'auto_increment')) {
                $consulta .= ' PRIMARY KEY AUTO_INCREMENT';
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
                $consulta .= ' DEFAULT ' . $defecto;
            }

            $consulta .= ', ';
        }
        $consulta = substr($consulta, 0, -2); // Quitamos la coma y el espacio del final
        $consulta .= ') ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;' . self::CRLF;

        return $consulta;
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
     * @param type $tablename
     * @param type $indexname
     * @param type $indexData
     * @return type
     */
    static protected function createIndex($tablename, $indexname, $indexData)
    {
        $consulta = "ALTER TABLE $tablename ADD CONSTRAINT $indexname ";

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
                        die('Esperaba un array en REFERENCES: ' . $tablename . '/' . $indexname);
                    }
                    if (count($references) != 1) {
                        die('Esperaba un array de 1 elemento en REFERENCES: ' . $tablename . '/' . $indexname);
                    }
                    $refTable = key($references);
                    $fields = '(' . implode($references, ',') . ')';
                } else {
                    die('FOREIGN necesita REFERENCES en ' . $tablename . '/' . $indexname);
                }

                $consulta .= $command . ' ' . $foreignField . ' REFERENCES ' . $refTable . $fields;

                if (isset($indexData['ON']) && is_array($indexData['ON'])) {
                    foreach ($indexData['ON'] as $key => $value) {
                        $consulta .= ' ON ' . $key . ' ' . $value . ', ';
                    }
                    $consulta = substr($consulta, 0, -2); // Quitamos el ', ' de detrás
                }
            }
        } else {
            if (is_array($fields)) {
                $fields = '(' . implode($fields, ',') . ')';
            } else {
                $fields = "($fields)";
            }

            if ($command == 'INDEX ') {
                $consulta = "CREATE INDEX {$indexname} ON {$tablename}" . $fields;
            } else {
                $consulta .= $command . ' ' . $fields;
            }
        }

        return $consulta . ';' . self::CRLF;
    }

    /**
     * Create the SQL statements to fill the table with default data.
     *
     * @param string $tablename
     * @param array $values
     * @return string
     */
    static protected function setValues(string $tablename, array $values): string
    {
        $consulta = "INSERT INTO $tablename ";
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
                $consulta .= $fields . " VALUES ";
                $header = false;
            }

            $consulta .= $datos;
        }

        return substr($consulta, 0, -2) . self::CRLF;
    }

    /**
     * Create a table in the database.
     * Build the default fields, indexes and values defined in the model.
     *
     * @param string $tablename
     * @return bool
     */
    static function createTable(string $tablename): bool
    {
        $tabla = Config::$bbddStructure[$tablename];
        $consulta = Self::createFields($tablename, $tabla['fields']);

        foreach ($tabla['keys'] as $name => $index) {
            $consulta .= self::createIndex($tablename, $name, $index);
        }
        $consulta .= self::setValues($tablename, $tabla['values']);
        return Config::$dbEngine->exec($consulta);
    }
}
