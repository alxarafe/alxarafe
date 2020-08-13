<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
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

    public static function setDataOfFile($path, $data)
    {
        self::$files[$path] = $data;
    }

    public static function deleteSummaryFiles()
    {
        $path = self::getSumaryFilesDir();
        return delTree($path);
    }

    public static function getSumaryFilesDir()
    {
        return basePath('config/structure');
    }

    /**
     * Save the summary file structure in a yaml file
     *
     * @param string $tableName
     * @param array  $data
     *
     * @return bool
     */
    public static function saveYamlSummaryFile(string $tableName, array $data)
    {
        $path = self::getSumaryFilesDir();
        FileSystemUtils::mkdir($path, 0777, true);
        $path .= DIRECTORY_SEPARATOR . $tableName . '.yaml';
        return file_put_contents($path, Yaml::dump($data, 3)) !== false;
    }

    /**
     * Returns an array with de summary file structure
     *
     * @param string $tableName
     *
     * @return array|null
     */
    public static function getFromYamlSummaryFile(string $tableName): ?array
    {
        $path = basePath("config/structure/{$tableName}.yaml");
        if (!file_exists($path) || !is_readable($path)) {
            return null;
        }
        return Yaml::parseFile($path);
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
     *
     * @deprecated: Remove. It may no longer be useful.
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

                /**
                 * TODO: Dataset must be mandatory?
                 * Either the dataset is set as mandatory, or it is assumed to be the main table of the controller,
                 * having to extract this assignment in case we are not in debug mode.
                 * The other option is to generate verified yaml for the viewdata, as is done with the structure.
                 */
                if (DEBUG) {
                    $debugTool = DebugTool::getInstance();
                    foreach ($schema['fields'] as $field => $values) {
                        $data['fields'][$field] = SchemaGenerator::mergeViewField($field, $values, $data['fields'][$field] ?? [], $tableName);
                        if ($data['fields'][$field]['dataset'] === null) {
                            $debugTool->addMessage('messages', "Field {$field} need 'dataset' in viewdata yaml for {$tableName} table?");
                            $data['fields'][$field]['dataset'] = $tableName;
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

        // We make sure the module table exists
        if (!SchemaDB::tableExists('modules')) {
            return '';
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
     * Create the SQL statements to fill the table with default data.
     *
     * @param string $tableName
     * @param array  $values
     *
     * @return array
     */
    public static function setValues(string $tableName, array $tabla, array $values): array
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
                $definitionDataField = $tabla['fields'][$fname];
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
