<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Base;

use Alxarafe\Core\Helpers\Schema;
use Alxarafe\Core\Providers\Database;

/**
 * Class SimpleTable has all the basic methods to access and manipulate information, but without modifying its
 * structure.
 */
class SimpleTable extends FlatTable
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
        $this->debugTool->startTimer($this->modelName, $this->modelName . ' SimpleTable Constructor');
        if (!isset($this->idField) && Database::getInstance()->getDbEngine()->issetDbTableStructureKey($this->tableName, 'fields')) {
            $this->idField = 'id';
            foreach (Database::getInstance()->getDbEngine()->getDbTableStructure($this->tableName)['fields'] as $key => $value) {
                if (isset($value['key']) && ($value['key'] === 'primary')) {
                    $this->idField = $key;
                    break;
                }
            }
        }
        $this->debugTool->stopTimer($this->modelName);
    }

    /**
     * Execute a call to setTableStructure with an array containing 3 arrays with the fields, keys and default values
     * for the table.
     *
     * The development will be more ambitious than what is defined.
     *
     * Currently Table includes a single table, but the idea is to be able to relate tables to form complex data
     * models.
     */
    public function setStructure(): void
    {
        $this->debugTool->startTimer($this->modelName . '->setStructure()', $this->modelName . ' SimpleTable->setStructure()');
        $this->setTableStructure($this->tableName, $this->getStructureArray());
        $this->debugTool->stopTimer($this->modelName . '->setStructure()');
    }

    /**
     * Save the structure of the table in a static array, so that it is available at all times.
     *
     * @param string $table
     * @param array  $structure
     */
    protected function setTableStructure(string $table, array $structure): void
    {
        if (!Database::getInstance()->getDbEngine()->issetDbTableStructure($table)) {
            Database::getInstance()->getDbEngine()->setDbTableStructure($table, Schema::setNormalizedStructure($structure, $table));
        }
    }

    /**
     * A raw array is built with all the information available in the table, configuration files and code.
     *
     * @return array
     */
    protected function getStructureArray(): array
    {
        $struct = Schema::getFromYamlFile($this->tableName);
        if (count($struct) > 0) {
            return $struct;
        }
        $struct['fields'] = method_exists($this, 'getFields') ? /** @scrutinizer ignore-call */
            $this->getFields() : ($this->getFieldsFromTable());
        return $struct;
    }

    /**
     * Return a list of fields and their table structure. Each final model that needed, must overwrite it.
     *
     * @return array
     */
    public function getFieldsFromTable(): array
    {
        return Database::getInstance()->getSqlHelper()->getColumns($this->tableName);
    }

    /**
     * Returns a new instance of the table with the requested record.
     * As a previous step, a getDataBy of the current instance is made, so both will point to the same record.
     * Makes a getDataBy and returns a new instance of the model.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return bool
     */
    public function getBy(string $key, $value): bool
    {
        return $this->getDataBy($key, $value);
    }

    /**
     * This method is private. Use getBy instead.
     * Establishes a record as an active record.
     * If found the pair $key-$value the data will be in $this->newData.
     * If it is not found, $this->id will contain '' and $this->newData will contain the data by default.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return bool
     */
    private function getDataBy(string $key, $value): bool
    {
        $fieldName = Database::getInstance()->getSqlHelper()->quoteFieldName($key);
        $sql = "SELECT * FROM {$this->getQuotedTableName()} WHERE {$fieldName} = :value;";
        $data = Database::getInstance()->getDbEngine()->select($sql, ['value' => $value]);
        if (!isset($data) || count($data) === 0) {
            $this->newRecord();
            return false;
        }
        $this->newData = $data[0];
        $this->oldData = $this->newData;
        $this->id = $this->newData[$this->idField];
        $this->exists = true;
        return true;
    }

    /**
     * Returns the structure of the normalized table
     *
     * @return array
     */
    public function getStructure(): array
    {
        return Database::getInstance()->getDbEngine()->getDbTableStructure($this->tableName);
    }

    /**
     * Get an array with all data in table.
     * WARNING: This could be dangerous with a big table.
     *
     * @return array
     */
    public function getAllRecords(): array
    {
        $sql = "SELECT * FROM {$this->getQuotedTableName()};";
        return Database::getInstance()->getDbEngine()->select($sql);
    }

    /**
     * Count all registers in table.
     *
     * @return int
     */
    public function countAllRecords(): int
    {
        $idField = Database::getInstance()->getSqlHelper()->quoteFieldName($this->getIdField());
        $sql = "SELECT COUNT({$idField}) AS total FROM {$this->getQuotedTableName()};";
        $data = Database::getInstance()->getDbEngine()->select($sql);
        return empty($data) ? 0 : (int) $data[0]['total'];
    }

    /**
     * Get an array with all data per page.
     *
     * @param int $offset
     *
     * @return array
     */
    public function getAllRecordsPaged(int $offset = 0): array
    {
        $limit = constant('DEFAULT_ROWS_PER_PAGE');
        $sql = "SELECT * FROM {$this->getQuotedTableName()} LIMIT {$limit} OFFSET {$offset};";
        return Database::getInstance()->getDbEngine()->select($sql);
    }

    /**
     * Do a search to a table.
     * Returns the result per page.
     *
     * @param string $query   What to look for
     * @param array  $columns For example: [0 => 'name']
     * @param int    $offset  By default 0
     * @param string $order   By default the main name field if defined
     *
     * @return array
     */
    public function search(string $query, array $columns = [], int $offset = 0, string $order = ''): array
    {
        $sql = $this->searchQuery($query, $columns);
        $limit = constant('DEFAULT_ROWS_PER_PAGE');
        $sql .= (!empty($order) ? " ORDER BY {$order}" : '')
            . " LIMIT {$limit} OFFSET {$offset};";

        return Database::getInstance()->getDbEngine()->select($sql);
    }

    /**
     * Return the main part of the search SQL query.
     *
     * @param string $query
     * @param array  $columns
     *
     * @return string
     */
    public function searchQuery(string $query, array $columns = []): string
    {
        $query = str_replace(' ', '%', $query);

        if ($this->getNameField() !== '' && empty($columns)) {
            $columns = [0 => $this->getNameField()];
        }

        $sql = "SELECT * FROM {$this->getQuotedTableName()}";
        $sep = '';
        if (!empty($columns) && !empty($query)) {
            $sql .= ' WHERE (';
            foreach ($columns as $pos => $col) {
                if ($col !== null && $col !== 'col-action') {
                    $fieldName = Database::getInstance()->getSqlHelper()->quoteFieldName($col);
                    $sql .= $sep . "lower({$fieldName}) LIKE '%" . $query . "%'";
                    $sep = ' OR ';
                }
            }
            $sql .= ')';
        }

        return $sql;
    }

    /**
     * Do a search to a table.
     * Returns the result per page.
     *
     * @param string $query   What to look for
     * @param array  $columns For example: [0 => 'name']
     *
     * @return int
     */
    public function searchCount(string $query, array $columns = []): int
    {
        $sql = $this->searchQuery($query, $columns);
        $idField = Database::getInstance()->getSqlHelper()->quoteFieldName($this->getIdField());
        $sql = str_replace('SELECT * ', "SELECT COUNT({$idField}) AS total ", $sql);
        $data = Database::getInstance()->getDbEngine()->select($sql);
        return empty($data) ? 0 : (int) $data[0]['total'];
    }
}
