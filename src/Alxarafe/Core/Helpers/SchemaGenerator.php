<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Helpers;

use Alxarafe\Core\Helpers\Utils\FileSystemUtils;
use Alxarafe\Core\Providers\Database;
use Alxarafe\Core\Providers\DebugTool;
use Symfony\Component\Yaml\Yaml;

/**
 * Generate yaml files from an existing database.
 */
class SchemaGenerator
{
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
            $data = self::mergeArray($structure, Schema::getFromYamlFile($table, $type), $type === 'viewdata');
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

        // if (!isset($result['type'])) {
        //     $result['type'] = $values['type'];
        //     $debugTool->addMessage('messages', "The {$field} field need 'type' in viewdata yaml for {$tablename} table.");
        // }

        switch ($values['type']) {
            case 'string':
                $length = (int) ($values['length'] ?? constant('DEFAULT_STRING_LENGTH'));
                $maxlength = max([(int) ($result['length'] ?? 0), $length]);
                if (!isset($result['maxlength'])) {
                    $debugTool->addMessage('messages', "The {$field} field need 'maxlength' ({$maxlength} suggest) in viewdata yaml for {$tablename} table.");
                    $result['maxlength'] = $maxlength;
                    break;
                }
                $maxlength = $result['maxlength'];
                if ($length !== $maxlength) {
                    $debugTool->addMessage('messages', "Warning! The {$field} field length is {$maxlength} in view and {$length} in struct for table {$tablename} table.");
                }
                break;
            case 'integer':
                // if ($result['type'] === 'bool') {
                //     $result['min'] = 0;
                //     $result['max'] = 1;
                //     break;
                // }

                if ($result['component'] === 'select') {
                    break;
                }

                if ($result['component'] === 'select2') {
                    break;
                }

                $length = $values['length'] ?? 8;
                if (!isset($values['length'])) {
                    $length = 8;
                    $debugTool->addMessage('messages', "The {$field} field need 'length' in struct yaml for {$tablename} table.");
                }

                if (isset($values['autoincrement']) && $values['autoincrement'] === 'yes') {
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

                if (!isset($result['min'])) {
                    $debugTool->addMessage('messages', "The {$field} field need 'min' ({$min} suggest) in viewdata yaml for {$tablename} table.");
                    $result['min'] = $values['min'] ?? $min;
                }

                if (!isset($result['max'])) {
                    $debugTool->addMessage('messages', "The {$field} field need 'max' ({$max} suggest) in viewdata yaml for {$tablename} table.");
                    $result['max'] = $values['max'] ?? $max;
                }

                $viewMin = (int) $result['min'];
                $viewMax = (int) $result['max'];

                $structMin = (int) ($values['min'] ?? $min);
                $structMax = (int) ($values['max'] ?? $max);

                if ($viewMin !== $structMin) {
                    $debugTool->addMessage('messages', "Warning! The {$field} field min is {$viewMin} in view and {$structMin} in struct for table {$tablename} table.");
                }
                if ($viewMax !== $structMax) {
                    $debugTool->addMessage('messages', "Warning! The {$field} field max is {$viewMax} in view and {$structMax} in struct for table {$tablename} table.");
                }
                break;
            case 'text':
                $result['type'] = 'textarea';
                break;
        }
        if (isset($values['default']) && !isset($result['default'])) {
            $result['default'] = $values['default'];
        }
        return $result;
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
        Schema::setDataOfFile($path, $data);
        return file_put_contents($path, Yaml::dump($data, 3)) !== false;
    }
}
