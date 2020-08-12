<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Base;

use Alxarafe\Core\Providers\Database;

/**
 * Class Table allows access to a table using an active record.
 * It is recommended to create a descendant for each table of the database, defining its tablename and structure.
 *
 * @property string $locked This field can exist or not (added here to avoid scrutinizer "property not exists")
 *
 * @package Alxarafe\Core\Base
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
        $create = $params['create'] ?? true;
        // $this->_checkStructure($create);
        $this->debugTool->stopTimer($this->shortName);
        $this->setData($this->defaultData());
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
        if ($this->nameField === '') {
            return '';
        }

        $nameField = Database::getInstance()->getSqlHelper()->quoteFieldName($this->nameField);
        $sql = "SELECT {$this->idField} AS id FROM {$this->getQuotedTableName()} WHERE {$nameField} = :name;";
        $data = Database::getInstance()->getDbEngine()->select($sql, ['name' => $name]);
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
     * @param string $comparison By default is '='
     * @param string $orderBy
     *
     * @return array
     */
    public function getAllRecordsBy(string $key, $value, string $comparison = '=', string $orderBy = ''): array
    {
        $fieldName = Database::getInstance()->getSqlHelper()->quoteFieldName($key);
        if (!empty($orderBy)) {
            $orderBy = " ORDER BY {$orderBy}";
        }
        if ($value === 'NULL') {
            $isNull = $comparison === '=' ? ' IS NULL' : ' IS NOT NULL';
            $sql = "SELECT * FROM {$this->getQuotedTableName()} WHERE {$fieldName}{$isNull}{$orderBy};";
        } else {
            $sql = "SELECT * FROM {$this->getQuotedTableName()} WHERE {$fieldName} {$comparison} :value{$orderBy};";
        }
        $vars = [];
        $vars['value'] = $value;
        return Database::getInstance()->getDbEngine()->select($sql, $vars);
    }

    /**
     * Return an array $key=>$value with all or selected records on the table.
     *
     * @param string $search
     *
     * @return array
     */
    public function getAllKeyValue($search = '')
    {
        $return = [];
        if ($search !== '') {
            $search = " WHERE {$this->nameField} LIKE '%{$search}%'";
        }
        $sql = "SELECT {$this->idField}, {$this->nameField} FROM {$this->getQuotedTableName()}{$search};";
        $result = Database::getInstance()->getDbEngine()->select($sql);
        foreach ($result as $record) {
            $return[$record[$this->idField]] = $record[$this->nameField];
        }
        return $return;
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
        if ($this->test($data)) {
            return $this->saveData($data);
        }
        return false;
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
        foreach ($data as $key => $value) {
            $this->load($key);
            $this->newData = $value;
            $ret &= $this->save();
        }
        return (bool) $ret;
    }

    /**
     * Return the value of the field description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        $field = $this->getNameField();
        return $this->{$field};
    }
}
