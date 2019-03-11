<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Helpers;

use Alxarafe\Core\Helpers\Utils\ClassUtils;
use Alxarafe\Core\Helpers\Utils\FileSystemUtils;
use Alxarafe\Core\Providers\Database;
use Alxarafe\Core\Providers\DebugTool;
use Alxarafe\Core\Providers\FlashMessages;
use Alxarafe\Core\Providers\Logger;
use Alxarafe\Core\Providers\ModuleManager;
use Exception;
use Kint\Kint;
use ParseCsv\Csv;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

/**
 * The Schema class contains static methods that allow you to manipulate the
 * database. It is used to create and modify tables and indexes in the database.
 */
class Schema
{
    /**
     * Schema constructor.
     */
    public function __construct()
    {
        $shortName = ClassUtils::getShortName($this, static::class);
        DebugTool::getInstance()->startTimer($shortName, $shortName . ' Schema Constructor');
        DebugTool::getInstance()->stopTimer($shortName);
    }

    /**
     * It collects the information from the database and creates files in YAML format
     * for the reconstruction of its structure. Also save the view structure.
     */
    public static function saveStructure(): void
    {
        $tables = Database::getInstance()->getSqlHelper()->getTables();
        foreach ($tables as $table) {
            self::saveTableStructure($table);
        }
    }

    /**
     * Return true if complete table structure was saved, otherwise return false.
     * If the name of the table includes the prefix used in the database, it is
     * removed from the name of the table.
     *
     * @param string $table
     *
     * @return bool
     */
    public static function saveTableStructure(string $table): bool
    {
        $result = true;
        $prefix = Database::getInstance()->getConnectionData()['dbPrefix'];
        $usePrefix = !empty($prefix);
        $tableName = $usePrefix ? substr($table, strlen($prefix)) : $table;
        $structure = Database::getInstance()->getDbEngine()->getStructure($tableName, $usePrefix);
        foreach (['schema', 'viewdata'] as $type) {
            $data = self::mergeArray($structure, self::getFromYamlFile($table, $type), $type === 'viewdata');
            $result = $result && self::saveSchemaFileName($data, $tableName, $type);
        }
        return $result;
    }

    /**
     * Merge the existing yaml file with the structure of the database,
     * prevailing the latter.
     *
     * @param array $struct current database table structure
     * @param array $data   current yaml file structure
     * @param bool  $isView
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
     * Verify the parameters established in the yaml file with the structure of the database, creating the missing data
     * and correcting the possible errors.
     *
     * Posible data: unique, min, max, length, pattern, placeholder, label & shortlabel
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
     * Verify the $fieldData established in the yaml file with the structure of
     * the database, creating the missing data and correcting the possible errors.
     *
     * Posible data: unique, min, max, length, pattern, placeholder, label & shortlabel
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

        $result['label'] = $result['label'] ?? $field;
        $result['shortlabel'] = $result['shortlabel'] ?? $field;
        $result['placeholder'] = $result['placeholder'] ?? $field;
        switch ($values['type']) {
            case 'string':
                $length = (int) ($values['length'] ?? constant('DEFAULT_STRING_LENGTH'));
                $result['length'] = max([(int) ($result['length'] ?? 0), $length]);
                break;
            case 'integer':
                $length = isset($values['length']) ? (10 ** $values['length']) - 1 : null;
                $max = (int) ($values['max'] ?? $length ?? (10 ** constant('DEFAULT_INTEGER_SIZE')) - 1);
                $min = ($values['unsigned'] === 'yes' ? 0 : -$max);
                $result['length'] = max([(int) ($result['length'] ?? 0), $length]);
                $result['min'] = min([(int) ($result['min'] ?? 0), $min]);
                $result['max'] = max([(int) ($result['min'] ?? 0), $max]);
                break;
        }
        return $result;
    }

    /**
     * Returns an array with data from the specified yaml file
     *
     * @param string $tableName
     * @param string $type must be 'schema' or 'viewdata'
     *
     * @return array
     */
    public static function getFromYamlFile(string $tableName, string $type = 'schema'): array
    {
        $fileName = self::getSchemaFileName($tableName, $type);
        if ($fileName === '') {
            return [];
        }
        if ($type === 'values') {
            $data = self::loadDataFromCsv($fileName);
            if (!empty($data)) {
                return $data;
            }
        }

        return self::loadDataFromYaml($fileName);
    }

    /**
     * Returns the path to the specified file, or empty string if it does not exist.
     *
     * @param string $tableName name of the file without extension (assumes .yaml or .csv according to the type)
     * @param string $type      It's the foldername (in lowercase). It's usually schema (by default) or viewdata.
     *
     * @return string
     */
    private static function getSchemaFileName(string $tableName, string $type = 'schema'): string
    {
        $extension = $type === 'values' ? '.csv' : '.yaml';

        // First, it is checked if it exists in the core
        $folder = constant('ALXARAFE_FOLDER') . DIRECTORY_SEPARATOR . 'Schema' . DIRECTORY_SEPARATOR . $type;
        FileSystemUtils::mkdir($folder, 0777, true);
        $path = $folder . DIRECTORY_SEPARATOR . $tableName . $extension;
        if (file_exists($path)) {
            return $path;
        }
        // And then if it exists in the application
        foreach (ModuleManager::getInstance()::getEnabledModules() as $module) {
            $folder = basePath($module['path'] . DIRECTORY_SEPARATOR . 'Schema' . DIRECTORY_SEPARATOR . $type);
            FileSystemUtils::mkdir($folder, 0777, true);
            $path = $folder . DIRECTORY_SEPARATOR . $tableName . $extension;
            if(file_exists($path)) {
                return $path;
            }
        }
        return '';
    }

    /**
     * Load data from CSV file.
     *
     * @param string $fileName
     *
     * @return array
     */
    public static function loadDataFromCsv(string $fileName): array
    {
        if (file_exists($fileName)) {
            $csv = new Csv();
            $csv->auto($fileName);
            return $csv->data;
        }
        return [];
    }

    /**
     * Load data from Yaml file.
     *
     * @param string $fileName
     *
     * @return array
     */
    public static function loadDataFromYaml(string $fileName): array
    {
        if (file_exists($fileName)) {
            try {
                return Yaml::parse(file_get_contents($fileName));
            } catch (ParseException $e) {
                Logger::getInstance()::exceptionHandler($e);
                FlashMessages::getInstance()::setError($e->getMessage());
                return [];
            }
        }
        return [];
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
        $path = basePath('config' . DIRECTORY_SEPARATOR . $type);
        FileSystemUtils::mkdir($path, 0777, true);
        $path .= DIRECTORY_SEPARATOR . $tableName . '.yaml';
        return file_put_contents($path, Yaml::dump($data, 3)) !== false;
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
        $ret['fields'] = $structure['fields'] ?? [];
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
    protected static function normalizeField(string $tableName, string $field, array $structure): ?array
    {
        if (!isset($structure['type'])) {
            Kint::dump("The type parameter is mandatory in {$field}. Error in table " . $tableName, $structure);
        }

        $dbType = $structure['type'];
        if (!in_array($structure['type'], ['integer', 'decimal', 'string', 'text', 'float', 'date', 'datetime'], true)) {
            $msg = "<p>Check Schema.normalizeField if you think that {$dbType} might be necessary.</p>";
            $msg .= "<p>Type {$dbType} is not valid for field {$field} of table {$tableName}</p>";
            $e = new Exception($msg);
            DebugTool::getInstance()->addException($e);
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
     * @return array
     */
    public static function setValues(string $tableName, array $values): array
    {
        $quotedTableName = Database::getInstance()->getSqlHelper()->quoteTableName($tableName);
        if (empty($values)) {
            return ['/* BAD QUERY empty list for table ' . $tableName . '-> */' . "SELECT 1 FROM {$quotedTableName};"];
        }

        $sql = "INSERT INTO {$quotedTableName} ";
        $header = true;
        $sep = '';
        foreach ($values as $value) {
            $fields = '(';
            $datos = $sep . '(';
            foreach ($value as $fname => $fvalue) {
                $fields .= Database::getInstance()->getSqlHelper()->quoteFieldName($fname) . ', ';
                $definitionDataField = Database::getInstance()->getDbEngine()->getDbTableStructure($tableName)['fields'][$fname];
                if ($fvalue === '' && $definitionDataField['nullable'] === 'yes') {
                    $fvalue = $definitionDataField['default'] ?? null;
                }
                $datos .= Database::getInstance()->getSqlHelper()->quoteLiteral($fvalue) . ', ';
            }
            $fields = substr($fields, 0, -2) . ')';
            $datos = substr($datos, 0, -2) . ')';

            if ($header) {
                $sql .= $fields . ' VALUES ';
                $header = false;
            }

            $sql .= $datos;
            $sep = ', ';
        }

        return [$sql . ';'];
    }
}
