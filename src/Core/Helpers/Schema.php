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
     * Carriage return
     */
    const CRLF = "\n\t";

    /**
     * Folder that contains the files with the structure of the database.
     */
    const SCHEMA_FOLDER = '/config/schema';

    /**
     * Folder that contains the files with the display parameters and
     * restrictions of the tables in the database.
     */
    const VIEW_DATA_FOLDER = '/config/viewdata';

    /**
     * Return the schema folder path.
     *
     * @return string
     */
    private static function getSchemaFolder()
    {
        return constant('BASE_PATH') . self::SCHEMA_FOLDER;
    }

    /**
     * Return the view data folder path.
     *
     * @return string
     */
    private static function getViewDataFolder()
    {
        return constant('BASE_PATH') . self::VIEW_DATA_FOLDER;
    }

    /**
     * Check the existence of the configuration folders that contain the YAML
     * files, creating them if they do not exist.
     * Returns true if finally, both folders exist.
     *
     * @return bool
     */
    protected static function checkConfigFolders(): bool
    {
        $ret = true;
        foreach ([self::getSchemaFolder(), self::getViewDataFolder()] as $folder) {
            if (!is_dir($folder)) {
                mkdir($folder);
            }
            $ret = $ret && is_dir($folder);
        }
        return $ret;
    }

    /**
     * Merge the existing yaml file with the structure of the database,
     * prevailing the latter.
     *
     * @param array $struct current database table structure
     * @param array $data current yaml file structure
     * @return array
     */
    protected static function mergeSchema(array $struct, array $data): array
    {
        return array_merge($data, $struct);
    }

    /**
     * Verify the parameters established in the yaml file with the structure 
     * of the database, creating the missing data and correcting the possible 
     * errors.
     * 
     * Posible data: unique, min, max, length, pattern, placeholder, rowlabel & fieldlabel
     * 
     * @param array $struct current database table structure
     * @param array $data current yaml file data
     * @return array
     */
    protected static function mergeViewData(array $struct, array $data): array
    {
        $result = [];
        foreach ($struct['fields'] as $field => $values) {
            $result[$field] = $data[$field] ?? [];
            $result[$field]['rowlabel'] = $result[$field]['rowlabel'] ?? $field;
            $result[$field]['fieldlabel'] = $result[$field]['fieldlabel'] ?? $field;
            $result[$field]['placeholder'] = $result[$field]['placeholder'] ?? $field;
            switch ($values['type']) {
                case 'string' :
                    $length = intval($values['length'] ?? constant(DEFAULT_STRING_LENGTH));
                    if (!isset($result[$field]['length']) || intval($result[$field]['length'] > $length)) {
                        $result[$field]['length'] = $length;
                    }
                    break;
                case 'integer' :
                    $length = isset($values['length']) ? pow(10, $values['length']) - 1 : null;
                    $max = intval($values['max'] ?? $length ?? pow(10, constant(DEFAULT_INTEGER_SIZE)) - 1);
                    $min = intval($values['unsigned'] == 'yes' ? 0 : -$max);
                    if (!isset($result[$field]['min']) || intval($result[$field]['min'] < $min)) {
                        $result[$field]['min'] = $min;
                    }
                    if (!isset($result[$field]['max']) || intval($result[$field]['max'] > $max)) {
                        $result[$field]['max'] = $max;
                    }
                    break;
            }
        }
        return $result;
    }

    /**
     * TODO: Undocummented
     */
    public static function saveStructure(): void
    {
        if (self::checkConfigFolders()) {
            $tables = Config::$sqlHelper->getTables();
            foreach ($tables as $table) {
                $filename = self::getSchemaFolder() . '/' . $table . '.yaml';
                $structure = Config::$dbEngine->getStructure($table, false);
                $dataFile = file_exists($filename) ? YAML::parse(file_get_contents($filename)) : [];
                $data = self::mergeSchema($structure, $dataFile);
                file_put_contents($filename, YAML::dump($data, 3));
                $filename = self::getViewDataFolder() . '/' . $table . '.yaml';
                $dataFile = file_exists($filename) ? YAML::parse(file_get_contents($filename)) : [];
                $data = self::mergeViewData($structure, $dataFile);
                file_put_contents($filename, YAML::dump($data, 3));
            }
        }
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
     * Take the definition of a field, and make sure you have all the information
     * that is necessary for its creation or maintenance, calculating the missing
     * data if possible.
     * It can cause an exception if some vital data is missing, but this should
     * only occur at the design stage.
     *
     * TODO: Netbeans does not support @return ?array
     *
     * @param string $tableName
     * @param string $field
     * @param array  $structure
     *
     * @return array|null
     */
    static protected function normalizeField(string $tableName, string $field, array $structure)
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

        return $structure;
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
        $sql = 'INSERT INTO ' . Config::$sqlHelper->quoteTableName($tableName) . ' ';
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
