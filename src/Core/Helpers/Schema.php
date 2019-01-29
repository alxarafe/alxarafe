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
     * Returns the path to the specified file, or empty string if it does not exist.
     *
     * @param string $tableName name of the file without extension (assumes .yaml)
     * @param string $type      It's the foldername (in lowercase). It's usually schema (by default) or viewdata.
     *
     * @return string
     */
    private static function getSchemaFileName(string $tableName, string $type = 'schema'): string
    {
        // First, it is checked if it exists in the core
        $path = constant('ALXARAFE_FOLDER') . '/Schema/' . $type . '/' . $tableName . '.yaml';
        if (file_exists($path)) {
            return $path;
        }
        // And then if it exists in the application
        $path = constant('BASE_PATH') . '/config/' . $type . '/' . $tableName . '.yaml';
        return file_exists($path) ? $path : '';
    }

    /**
     * Save the data array in a .yaml file
     *
     * @param array  $data
     * @param string $tableName
     * @param string $type
     *
     * @return bool
     */
    private static function saveSchemaFileName(array $data, string $tableName, string $type = 'schema'): bool
    {
        $path = constant('BASE_PATH') . '/config/' . $type;
        if (!is_dir($path)) {
            \mkdir($path, 0777, true);
        }
        $path .= '/' . $tableName . '.yaml';
        return file_put_contents($path, Yaml::dump($data, 3)) !== false;
    }

    /**
     * Verify the $fieldData established in the yaml file with the structure of
     * the database, creating the missing data and correcting the possible errors.
     *
     * Posible data: unique, min, max, length, pattern, placeholder, rowlabel & fieldlabel
     *
     * @param string $field
     * @param array  $values
     * @param array  $fieldData
     *
     * @return array
     */
    protected static function mergeViewField(string $field, array $values, array $fieldData): array
    {
        $result = $fieldData ?? [];

        $result['rowlabel'] = $result['rowlabel'] ?? $field;
        $result['fieldlabel'] = $result['fieldlabel'] ?? $field;
        $result['placeholder'] = $result['placeholder'] ?? $field;
        switch ($values['type']) {
            case 'string':
                $length = intval($values['length'] ?? constant(DEFAULT_STRING_LENGTH));
                $result['length'] = max([intval($result['length']) ?? 0, $length]);
                break;
            case 'integer':
                $length = isset($values['length']) ? pow(10, $values['length']) - 1 : null;
                $max = intval($values['max'] ?? $length ?? pow(10, constant(DEFAULT_INTEGER_SIZE)) - 1);
                $min = intval($values['unsigned'] == 'yes' ? 0 : -$max);
                $result['min'] = min([intval($result['min'] ?? 0), $min]);
                $result['max'] = max([intval($result['min'] ?? 0), $max]);
                break;
        }
        return $result;
    }

    /**
     * Verify the parameters established in the yaml file with the structure of the database, creating the missing data
     * and correcting the possible errors.
     *
     * Posible data: unique, min, max, length, pattern, placeholder, rowlabel & fieldlabel
     *
     * @param array $struct current database table structure
     * @param array $data   current yaml file data
     *
     * @return array
     */
    protected static function mergeViewData(array $struct, array $data): array
    {
        $result = [];
        foreach ($struct['fields'] as $field => $values) {
            $result[$field] = self::mergeViewField($field, $values, $data[$field] ?? []);
        }
        return $result;
    }

    /**
     * Merge the existing yaml file with the structure of the database,
     * prevailing the latter.
     *
     * @param array $struct current database table structure
     * @param array $data   current yaml file structure
     *
     * @return array
     */
    protected static function mergeArray(array $struct, array $data, $isView = false): array
    {
        if ($isView) {
            return self::mergeViewData($struct, $data);
        }
        return array_merge($data, $struct);
    }

    /**
     * Returns an array with data from the specefied yaml file
     *
     * @param string $tableName
     * @param string $type must be 'schema' or 'viewdata'
     *
     * @return array
     */
    public static function getFromYamlFile(string $tableName, string $type = 'schema'): array
    {
        $fileName = self::getSchemaFileName($tableName, $type);
        return $fileName == '' ? [] : Yaml::parse(file_get_contents($fileName));
    }

    /**
     * It collects the information from the database and creates files in YAML format
     * for the reconstruction of its structure. Also save the view structure.
     */
    public static function saveStructure(): void
    {
        $tables = Config::$sqlHelper->getTables();
        foreach ($tables as $table) {
            self::saveTableStructure($table);
        }
    }

    /**
     * Return true if complete table structure was saved, otherwise return false.
     *
     * @param string $table
     *
     * @return bool
     */
    public static function saveTableStructure(string $table): bool
    {
        $result = true;
        $structure = Config::$dbEngine->getStructure($table, false);
        foreach (['schema', 'viewdata'] as $type) {
            $data = self::mergeArray($structure, self::getFromYamlFile($table, $type), $type == 'viewdata');
            $result = $result && self::saveSchemaFileName($data, $table, $type);
        }
        return $result;
    }

    /**
     * Normalize an array that has the file structure defined in the model by setStructure, so that it has fields with
     * all the values it must have. Those that do not exist are created with the default value, avoiding having to do
     * the check each time, or calculating their value based on the data provided by the other fields.
     *
     * It also ensures that the keys and default values exist as an empty array if they did not exist.
     *
     * @param array  $structure
     * @param string $tableName
     *
     * @return array
     */
    public static function setNormalizedStructure(array $structure, string $tableName): array
    {
        $ret = [];
        $ret['indexes'] = $structure['indexes'] ?? [];
        $ret['values'] = $structure['values'] ?? [];
        foreach ($structure['fields'] as $key => $value) {
            $ret['fields'][$key] = self::normalizeField($tableName, $key, $value);
        }
        $ret['checks'] = $structure['checks'] ?? [];
        return $ret;
    }

    /**
     * Take the definition of a field, and make sure you have all the information that is necessary for its creation or
     * maintenance, calculating the missing data if possible. It can cause an exception if some vital data is missing,
     * but this should only occur at the design stage.
     *
     * @param string $tableName
     * @param string $field
     * @param array  $structure
     *
     * @return array|null
     */
    protected static function normalizeField(string $tableName, string $field, array $structure)
    {
        if (!isset($structure['type'])) {
            Debug::testArray("The type parameter is mandatory in {$field}. Error in table " . $tableName, $structure);
        }

        $dbType = $structure['type'];
        if (!in_array($structure['type'], ['integer', 'decimal', 'string', 'text', 'float', 'date', 'datetime'])) {
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
    public static function setValues(string $tableName, array $values): string
    {
        if (empty($values)) {
            return '/* BAD QUERY -> */' . 'SELECT 1 FROM ' . Config::$sqlHelper->quoteTableName($tableName) . ';';
        }

        $sql = 'INSERT INTO ' . Config::$sqlHelper->quoteTableName($tableName) . ' ';
        $header = true;
        $sep = '';
        foreach ($values as $value) {
            $fields = "(";
            $datos = $sep . "(";
            foreach ($value as $fname => $fvalue) {
                $fields .= Config::$sqlHelper->quoteFieldName($fname) . ", ";
                $datos .= Config::$sqlHelper->quoteLiteral($fvalue) . ", ";
            }
            $fields = substr($fields, 0, -2) . ")";
            $datos = substr($datos, 0, -2) . ")";

            if ($header) {
                $sql .= $fields . " VALUES ";
                $header = false;
            }

            $sql .= $datos;
            $sep = ', ';
        }

        return $sql . ';' . self::CRLF;
    }
}
