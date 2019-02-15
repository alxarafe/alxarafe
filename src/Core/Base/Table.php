<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Base;

use Alxarafe\Helpers\Config;
use Alxarafe\Helpers\Debug;
use Alxarafe\Helpers\Schema;
use Alxarafe\Helpers\SchemaDB;
use Alxarafe\Models\TableModel;
use ReflectionClass;

/**
 * Class Table allows access to a table using an active record.
 * It is recommended to create a descendant for each table of the database, defining its tablename and structure.
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
        $shortName = (new ReflectionClass($this))->getShortName();
        Debug::startTimer($shortName, $shortName . ' Table Constructor');

        $create = $params['create'] ?? false;
        $this->checkStructure($create);
        Debug::stopTimer($shortName);
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
        if (!$create || !isset(Config::$bbddStructure[$this->tableName])) {
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

        $sql = "SELECT {$this->idField} AS id FROM " . Config::$sqlHelper->quoteTableName($this->tableName)
            . ' WHERE ' . Config::$sqlHelper->quoteFieldName($this->nameField) . ' = ' . Config::$sqlHelper->quoteLiteral($name) . ';';
        $data = Config::$dbEngine->select($sql);
        if (!empty($data) && count($data) > 0) {
            return $data[0]['id'];
        }

        return '';
    }
    /**
     * Return a list of fields and their table structure.
     * Each final model that needed, must overwrite it.
     *
     * @return array
     */
    //abstract public function getFields();

    /**
     * Returns the structure of the normalized table.
     *
     * @return array
     */
    public function getStructure(): array
    {
        return Config::$bbddStructure[$this->tableName];
    }

    /**
     * Get an array with all data.
     *
     * @return array
     */
    public function getAllRecords(): array
    {
        $sql = 'SELECT * FROM ' . Config::$sqlHelper->quoteTableName($this->tableName) . ';';
        return Config::$dbEngine->select($sql);
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
        $sql = 'SELECT * FROM ' . Config::$sqlHelper->quoteTableName($this->tableName)
            . ' WHERE ' . Config::$sqlHelper->quoteFieldName($key) . ' = :value;';
        $vars = [];
        $vars['value'] = $value;
        return Config::$dbEngine->select($sql, $vars);
    }

    /**
     * A raw array is built with all the information available in the table, configuration files and code.
     *
     * @return array
     */
    protected function getStructureArray(): array
    {
        $struct = parent::getStructureArray();
        // If indexes exists, it's loaded from yaml file
        if (!isset($struct['indexes'])) {
            $struct['indexes'] = method_exists($this, 'getKeys') ? /** @scrutinizer ignore-call */
                $this->getKeys() : $this->getIndexesFromTable();
            if (method_exists($this, 'getDefaultValues')) {
                if (!isset($struct['values'])) {
                    $struct['values'] = [];
                }
                $struct['values'] = array_merge($struct['values'], /** @scrutinizer ignore-call */ $this->getDefaultValues());
            }
        }
        $struct['checks'] = method_exists($this, 'getChecks') ? /** @scrutinizer ignore-call */ $this->getChecks() : $this->getChecksFromTable();
        return $struct;
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
        return Config::$sqlHelper->getIndexes($this->tableName, true);
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
     * Return a list of default values.
     * Each final model that needed, must overwrite it.
     *
     * @return array
     */
    public function getDefaultValues(): array
    {
        $items = [];
        foreach ($this->getStructure()['fields'] as $key => $valueData) {
            $items[$key] = $valueData['default'] ?? '';
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
        $item = '';
        if ($item === '' && $valueData['nullable'] === 'no') {
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
                case '':
                    break;
                default:
                    $item = $valueData['default'];
            }
        }
        return $item;
    }
}
