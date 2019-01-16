<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Base;

use Alxarafe\Helpers\Config;
use Alxarafe\Helpers\Schema;

/**
 * Class Table allows access to a table using an active record.
 * It is recommended to create a descendant for each table of the database,
 * defining its tablename and structure.
 */
class Table extends SimpleTable
{
    /**
     * It is the name of the field name. By default 'name'.
     * TODO: See if it may not exist, in which case, null or ''?
     *
     * @var string
     */
    protected $nameField;

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
        $this->nameField = $params['nameField'] ?? null;

        $create = $params['create'] ?? false;
        $this->checkStructure($create);
    }

    /**
     * Create a new table if it does not exist and it has been passed true as a parameter.
     *
     * This should check if there are differences between the defined in bbddStructure
     * and the physical table, correcting the differences if true is passed as parameter.
     *
     * @param bool $create
     */
    public function checkStructure(bool $create = false): void
    {
        if (isset(Config::$bbddStructure[$this->tableName])) {
            if ($create && !Schema::tableExists($this->tableName)) {
                Schema::createTable($this->tableName);
            }
        }
    }

    /**
     * Returns the name of the identification field of the record. By default it
     * will be name.
     *
     * @return string
     */
    public function getNameField(): string
    {
        return $this->nameField;
    }

    /**
     * Perform a search of a record by the name, returning the id of the
     * corresponding record, or '' if it is not found or does not have a
     * name field.
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

        $sql = "SELECT {$this->idField} AS id FROM " . Config::getVar('dbPrefix') . $this->tableName . " WHERE {$this->nameField}='$name'";
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
     * public function getFields(): array
     * {
     * return parent::getFields();
     * }
     */

    /**
     * Returns the structure of the normalized table
     *
     * @return array
     */
    public function getStructure(): array
    {
        return Config::$bbddStructure[$this->tableName];
    }

    /**
     * Get an array with all data
     *
     * @return array
     */
    public function getAllRecords(): array
    {
        $sql = 'SELECT * FROM ' . $this->getTableName();
        return Config::$dbEngine->select($sql);
    }

    /**
     * A raw array is built with all the information available in the table, configuration files and code.
     *
     * @return array
     */
    protected function getStructureArray(): array
    {
        $struct = parent::getStructureArray();
        $struct['keys'] = method_exists($this, 'getKeys') ? $this->getKeys() : $this->getIndexesFromTable();
        $struct['values'] = $this->getDefaultValues();
        $struct['checks'] = $this->getChecks();
        return $struct;
    }

    /**
     * Return a list of key indexes.
     * Each final model that needed, must overwrite it.
     *
     * @return array
     */
    public function getIndexesFromTable(): array
    {
        return Config::$sqlHelper->getIndexes($this->tableName);
    }

    /**
     * Return a list of default values.
     * Each final model that needed, must overwrite it.
     *
     * @return array
     */
    public function getDefaultValues(): array
    {
        return [];
    }

    public function getChecks(): array
    {
        return [];
    }
}
