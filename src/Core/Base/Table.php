<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Base;

use Alxarafe\Helpers\Schema;
use Alxarafe\Helpers\SchemaDB;
use Alxarafe\Models\TableModel;
use Alxarafe\Providers\Database;
use Alxarafe\Providers\FlashMessages;
use ReflectionClass;

/**
 * Class Table allows access to a table using an active record.
 * It is recommended to create a descendant for each table of the database, defining its tablename and structure.
 *
 * @property string $locked This field can exist or not (added here to avoid scrutinizer "property not exists")
 *
 * @package Alxarafe\Base
 */
class Table extends SimpleTable
{

    /**
     * Build a Table model. $table is the name of the table in the database.
     * $params is a parameters array:
     * - create is true if the table is to be created if it does not exist (false by default)
     * - idField is the name of the primary key (default id)
     * - nameField is the name of the descriptive field (name by default)
     *
     * @param string $tableName
     * @param array  $params
     */
    public function __construct(string $tableName, array $params = [])
    {
        parent::__construct($tableName, $params);
        $this->debugTool->startTimer($this->shortName, $this->shortName . ' Table Constructor');
        $create = $params['create'] ?? false;
        $this->checkStructure($create);
        $this->debugTool->stopTimer($this->shortName);
    }

    /**
     * Create a new table if it does not exist and it has been passed true as a parameter.
     *
     * This should check if there are differences between the defined in bbddStructure and the physical table,
     * correcting the differences if true is passed as parameter.
     *
     * @param bool $create
     */
    public function checkStructure(bool $create = false): void
    {
        if (!$create || !Database::getInstance()->getDbEngine()->issetDbTableStructure($this->tableName)) {
            return;
        }
        if (!SchemaDB::tableExists($this->tableName) && $this->modelName != 'TableModel') {
            $tableModel = new TableModel();
            if (!$tableModel->load($this->tableName)) {
                $tableModel->tablename = $this->tableName;
                $tableModel->model = $this->modelName;
                $tableModel->namespace = (new ReflectionClass($this))->getName();
                $tableModel->save();
            }
        }
        SchemaDB::checkTableStructure($this->tableName);
    }

    /**
     * Perform a search of a record by the name, returning the id of the corresponding record, or '' if it is not found
     * or does not have a name field.
     *
     * @param string $name
     *
     * @return string
     */
    public function getIdByName(string $name): string
    {
        if ($this->nameField == '') {
            return '';
        }

        $sql = "SELECT {$this->idField} AS id FROM " . Database::getInstance()->getSqlHelper()->quoteTableName($this->tableName)
            . ' WHERE ' . Database::getInstance()->getSqlHelper()->quoteFieldName($this->nameField) . ' = ' . Database::getInstance()->getSqlHelper()->quoteLiteral($name) . ';';
        $data = Database::getInstance()->getDbEngine()->select($sql);
        if (!empty($data) && count($data) > 0) {
            return $data[0]['id'];
        }

        return '';
    }

    /**
     * Get an array with all data.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return array
     */
    public function getAllRecordsBy(string $key, $value): array
    {
        $sql = 'SELECT * FROM ' . Database::getInstance()->getSqlHelper()->quoteTableName($this->tableName)
            . ' WHERE ' . Database::getInstance()->getSqlHelper()->quoteFieldName($key) . ' = :value;';
        $vars = [];
        $vars['value'] = $value;
        return Database::getInstance()->getDbEngine()->select($sql, $vars);
    }

    /**
     * Return a list of key indexes.
     * Each final model that needed, must overwrite it.
     *
     * TODO: Why "*FromTable()" need to be overwrited on final model? Is not from model definition.
     *
     * @return array
     */
    public function getIndexesFromTable(): array
    {
        return Database::getInstance()->getSqlHelper()->getIndexes($this->tableName, true);
    }

    /**
     * Return a list of default values.
     * Each final model that needed, must overwrite it.
     *
     * @return array
     */
    public function getDefaultValues(): array
    {
        $items = [];
        foreach ($this->getStructure()['fields'] as $key => $valueData) {
            $items[$key] = $this->getDefaultValue($valueData);
        }
        return $items;
    }

    /**
     * Get default value data for this valueData.
     *
     * @param array $valueData
     *
     * @return bool|false|int|string
     */
    private function getDefaultValue(array $valueData)
    {
        $item = $valueData['default'] ?? '';
        if ($valueData['nullable'] === 'no') {
            switch ($valueData['type']) {
                case 'integer':
                case 'number':
                case 'email':
                    $item = 0;
                    break;
                case 'checkbox':
                    $item = false;
                    break;
                case 'date':
                    $item = date('Y-m-d');
                    break;
                case 'datetime':
                    $item = date('Y-m-d H:i:s');
                    break;
                case 'time':
                    $item = date('H:i:s');
                    break;
                case 'string':
                case 'text':
                case 'textarea':
                case 'blob':
                case 'data':
                case 'link':
                    $item = '';
                    break;
                default:
                    $item = $valueData['default'];
            }
        }
        return $item;
    }

    /**
     * TODO: Undocumented
     *
     * @return array
     */
    public function getChecksFromTable(): array
    {
        return Schema::getFromYamlFile($this->tableName, 'viewdata');
    }

    /**
     * Save the data to a record if pass the test and returns true/false based on the result.
     *
     * @param array $data
     *
     * @return bool
     */
    public function saveRecord(array $data): bool
    {
        if ($ret = $this->testData($data)) {
            $ret = $this->saveData($data);
        }
        return $ret;
    }

    /**
     * TODO: Undocumented
     *
     * @param $data
     *
     * @return bool
     */
    protected function testData($data): bool
    {
        $ok = true;
        foreach ($data as $tableName => $block) {   // Recorrer tablas
            foreach ($block as $blockId => $record) {            // Recorrer registros de la tabla (seguramente uno)
                foreach (Database::getInstance()->getDbEngine()->getDbTableStructure($tableName)['checks'] as $fieldName => $fieldStructure) {
                    $length = $fieldStructure['length'] ?? null;
                    if (isset($length) && $length > 0) {
                        if (strlen($record[$fieldName]) > $length) {
                            FlashMessages::getInstance()::setError("$tableName-$fieldName: Longitud máxima {$length}.");
                            $ok = false;
                        }
                    }
                    $min = $fieldStructure['min'] ?? null;
                    if (isset($min)) {
                        if ($min > intval($record[$fieldName])) {
                            FlashMessages::getInstance()::setError("$tableName-$fieldName: Supera el mínimo de {$min}.");
                            $ok = false;
                        }
                    }
                    $max = $fieldStructure['max'] ?? null;
                    if (isset($max)) {
                        if ($max < intval($record[$fieldName])) {
                            FlashMessages::getInstance()::setError("$tableName-$fieldName: Supera el máximo {$max}.");
                            $ok = false;
                        }
                    }
                    if (isset($fieldStructure['unique']) && ($fieldStructure['unique'] == 'yes')) {
                        // $fullTableName = $this->getTableName();
                        $fullTableName = Database::getInstance()->getSqlHelper()->quoteTableName($this->tableName);
                        $bad = Database::getInstance()->getDbEngine()->select("SELECT * FROM {$fullTableName} WHERE $fieldName='{$data[$tableName][$blockId][$fieldName]}'");
                        if ($bad && count($bad) > 0) {
                            foreach ($bad as $badrecord) {
                                // TODO: Estoy utilizando 'id', pero tendría que ser el $this->idField del modelo correspondiente
                                if ($badrecord['id'] != $data[$tableName][$blockId]['id']) {
                                    FlashMessages::getInstance()::setError("$tableName-$fieldName: Valor '{$data[$tableName][$blockId][$fieldName]}' duplicado con registro {$badrecord['id']}.");
                                    $ok = false;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $ok;
    }

    /**
     * Try to save the data and return true/false based on the result.
     *
     * @param array $data
     *
     * @return bool
     */
    protected function saveData(array $data): bool
    {
        $ret = true;
        foreach ($data[$this->tableName] as $key => $value) {
            $this->load($key);
            $this->newData = $value;
            $ret &= $this->save();
        }
        return (bool) $ret;
    }
}
