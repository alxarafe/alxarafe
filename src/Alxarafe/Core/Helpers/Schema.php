<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Helpers;

use Alxarafe\Core\Database\Engine;
use Alxarafe\Core\Helpers\Utils\ClassUtils;
use Alxarafe\Core\Helpers\Utils\FileSystemUtils;
use Alxarafe\Core\Providers\Database;
use Alxarafe\Core\Providers\DebugTool;
use Alxarafe\Core\Providers\FlashMessages;
use Alxarafe\Core\Providers\Logger;
use Alxarafe\Core\Providers\ModuleManager;
use Alxarafe\Core\Providers\Translator;
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
     * Content files yet readed.
     *
     * @var array
     */
    private static $files;

    /**
     * Schema constructor.
     */
    public function __construct()
    {
        $shortName = ClassUtils::getShortName($this, static::class);
        DebugTool::getInstance()->startTimer($shortName, $shortName . ' Schema Constructor');
        DebugTool::getInstance()->stopTimer($shortName);
        self::$files = [];
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
     * @param string $tablename
     *
     * @return array
     */
    public static function mergeViewField(string $field, array $values, array $fieldData, string $tablename = 'undefined'): array
    {
        $debugTool = DebugTool::getInstance();

        $result = $fieldData ?? [];

        foreach (['label', 'shortlabel', 'placeholder'] as $fieldName) {
            if (!isset($result[$fieldName])) {
                $result[$fieldName] = $field;
                $debugTool->addMessage('messages', "Field {$field} need '{$fieldName}' in viewdata yaml for {$tablename} table.");
            }
        }

        if (!$result['type']) {
            $result['type'] = $values['type'];
            $debugTool->addMessage('messages', "The {$field} field need 'type' in viewdata yaml for {$tablename} table.");
        }

        switch ($values['type']) {
            case 'string':
                $length = (int) ($values['length'] ?? constant('DEFAULT_STRING_LENGTH'));
                $maxlength = max([(int) ($result['length'] ?? 0), $length]);
                if (!$result['maxlength']) {
                    $debugTool->addMessage('messages', "The {$field} field need 'maxlength' ({$maxlength} suggest) in viewdata yaml for {$tablename} table.");
                    $result['maxlength'] = $maxlength;
                    break;
                }
                $maxlength = $result['maxlength'];
                if ($length != $maxlength) {
                    $debugTool->addMessage('messages', "Warning! The {$field} field length is {$maxlength} in view and {$length} in struct for table {$tablename} table.");
                }
                break;
            case 'integer':
                $length = $values['length'] ?? 8;
                if (!isset($values['length'])) {
                    $length = 8;
                    $debugTool->addMessage('messages', "The {$field} field need 'length' in struct yaml for {$tablename} table.");
                }

                if (isset($values['autoincrement']) && $values['autoincrement'] == 'yes') {
                    break;
                }

                $bits = 8 * $length;
                $total = 2 ** $bits;

                $unsigned = isset($values['unsigned']) && $values['unsigned'] === 'yes';
                if ($unsigned) {
                    $min = 0;
                    $max = $total - 1;
                } else {
                    $min = -$total / 2;
                    $max = $total / 2 - 1;
                }

                if (!$result['min']) {
                    $debugTool->addMessage('messages', "The {$field} field need 'min' ({$min} suggest) in viewdata yaml for {$tablename} table.");
                    $result['min'] = $values['min'] ?? $min;
                }

                if (!$result['max']) {
                    $debugTool->addMessage('messages', "The {$field} field need 'max' ({$max} suggest) in viewdata yaml for {$tablename} table.");
                    $result['max'] = $values['max'] ?? $max;
                }

                $viewMin = (int) $result['min'];
                $viewMax = (int) $result['max'];

                if ($viewMin != $min) {
                    $debugTool->addMessage('messages', "Warning! The {$field} field min is {$viewMin} in view and {$min} in struct for table {$tablename} table.");
                }
                if ($viewMax != $max) {
                    $debugTool->addMessage('messages', "Warning! The {$field} field max is {$viewMax} in view and {$max} in struct for table {$tablename} table.");
                }
                break;
            default:
                switch ($values['type']) {
                    case 'text':
                        $result['type'] = 'textarea';
                    default:
                }
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

        switch ($type) {
            case 'schema':
                $data = self::loadDataFromYaml($fileName);
                break;
            case 'viewdata':
                $schema = self::getFromYamlFile($tableName);
                $data = self::loadDataFromYaml($fileName);

                // If not defined in yaml file, use all table fields
                if (empty($data['fields'])) {
                    foreach ($schema['fields'] as $key => $value) {
                        $data['fields'][$key] = [];
                    }
                }

                if (DEBUG) {
                    foreach ($schema['fields'] as $field => $values) {
                        $data['fields'][$field] = self::mergeViewField($field, $values, $data['fields'][$field] ?? [], $tableName);
                    }
                }

                // Some fields may need auto-translation
                foreach ($data['fields'] as $field => $properties) {
                    foreach ($properties as $key => $value) {
                        switch ($key) {
                            case 'label':
                            case 'shortlabel':
                            case 'placeholder':
                                $data['fields'][$field][$key] = Translator::getInstance()->trans($value);
                                break;
                        }
                    }
                }
                break;
            case 'values':
                $data = self::loadDataFromCsv($fileName);
                break;
            default:
                $data = [];
        }
        return $data;
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
        $folder = realpath(constant('ALXARAFE_FOLDER') . DIRECTORY_SEPARATOR . 'Schema') . DIRECTORY_SEPARATOR . $type;
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
            if (file_exists($path)) {
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
            if (isset(self::$files[$fileName])) {
                return self::$files[$fileName];
            }
            try {
                return self::$files[$fileName] = Yaml::parseFile($fileName);
            } catch (ParseException $e) {
                Logger::getInstance()::exceptionHandler($e);
                FlashMessages::getInstance()::setError($e->getFile() . ' ' . $e->getLine() . ' ' . $e->getMessage());
                FlashMessages::getInstance()::setError($fileName . ': <pre>' . var_export(Yaml::parseFile($fileName), true) . '</pre>');
                return [];
            }
        }
        FlashMessages::getInstance()::setError("File '" . $fileName . "' not exists");
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
        self::$files[$path] = $data;
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
        $ret['checks'] = self::getFromYamlFile($tableName, 'viewdata');
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
        if (!in_array($structure['type'], ['integer', 'float', 'decimal', 'string', 'text', 'bool', 'date', 'time', 'datetime'], true)) {
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
