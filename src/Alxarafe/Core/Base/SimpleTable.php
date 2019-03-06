<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Base;

use Alxarafe\Core\Helpers\Schema;
use Alxarafe\Core\Providers\Database;

/**
 * Class SimpleTable has all the basic methods to access and manipulate information, but without modifying its
 * structure.
 */
class SimpleTable extends Entity
{
    /**
     * It is the name of the table.
     *
     * @var string
     */
    public $tableName;

    /**
     * It's the name of the model associated with the table
     *
     * @var string
     */
    public $modelName;

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
        parent::__construct();
        $this->modelName = $this->shortName;
        $this->debugTool->startTimer($this->modelName, $this->modelName . ' SimpleTable Constructor');
        $this->tableName = $tableName;
        $this->idField = $params['idField'] ?? null;
        $this->nameField = $params['nameField'] ?? null;
        $this->setStructure();
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
     * As a previous step, a getData of the current instance is made, so both will point to the same record.
     * Makes a getData and returns a new instance of the model.
     *
     * @param string $id
     *
     * @return SimpleTable
     */
    public function get(string $id): self
    {
        $this->getDataById($id);
        return $this;
    }

    /**
     * This method is private. Use load instead.
     * Establishes a record as an active record.
     * If found, the $id will be in $this->id and the data in $this->newData.
     * If it is not found, $this->id will contain '' and $this->newData will contain the data by default.
     *
     * @param string $id
     *
     * @return bool
     */
    private function getDataById(string $id): bool
    {
        $idField = Database::getInstance()->getSqlHelper()->quoteFieldName($this->idField);
        $sql = "SELECT * FROM {$this->getQuotedTableName()} WHERE {$idField} = :id;";
        $data = Database::getInstance()->getDbEngine()->select($sql, ['id' => $id]);
        if (!isset($data) || count($data) === 0) {
            $this->newRecord();
            return false;
        }
        $this->newData = $data[0];
        $this->oldData = $this->newData;
        $this->id = $this->newData[$this->idField];
        return true;
    }

    /**
     * Get the name of the table (with prefix)
     *
     * @param bool $usePrefix
     *
     * @return string
     */
    public function getQuotedTableName(bool $usePrefix = true): string
    {
        return Database::getInstance()->getSqlHelper()->quoteTableName($this->tableName, $usePrefix);
    }

    /**
     * Sets the active record in a new record.
     * Note that changes made to the current active record will be lost.
     */
    private function newRecord(): void
    {
        $this->id = '';
        $this->newData = [];
        foreach (Database::getInstance()->getDbEngine()->getDbTableStructure($this->tableName)['fields'] as $key => $value) {
            $this->newData[$key] = $value['default'] ?? '';
        }
        $this->oldData = $this->newData;
    }

    /**
     * Deletes the active record.
     *
     * @return bool
     */
    public function delete(): bool
    {
        if (empty($this->id)) {
            return false;
        }
        $idField = Database::getInstance()->getSqlHelper()->quoteFieldName($this->idField);
        $sql = "DELETE FROM {$this->getQuotedTableName()} WHERE {$idField} = :id;";
        $vars = [];
        $vars['id'] = $this->id;
        $result = Database::getInstance()->getDbEngine()->exec($sql, $vars);
        if ($result) {
            $this->id = null;
            $this->newData = null;
            $this->oldData = null;
        }
        return $result;
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
        return true;
    }

    /**
     * Get the name of the table (with prefix)
     *
     * @param bool $usePrefix
     *
     * @return string
     */
    public function getTableName(bool $usePrefix = true): string
    {
        return ($usePrefix ? Database::getInstance()->getConnectionData()['dbPrefix'] : '') . $this->tableName;
    }

    /**
     * Return an array with the current active record.
     * If an $id is indicated, it searches to change the active record before returning the value.
     * Warning: If an $id is set, any unsaved data will be lost when searching for the new record.
     *
     * @param string $id
     *
     * @return array
     */
    public function getDataArray(string $id = null): array
    {
        if (isset($id) && ($id !== $this->id)) {
            $this->getDataById($id);
        }
        return $this->newData;
    }

    /**
     * Establishes a record as an active record.
     * If found, the $id will be in $this->id and the data in $this->newData.
     * If it is not found, $this->id will contain '' and $this->newData will contain the data by default.
     *
     * @param string $id
     *
     * @return bool
     */
    public function load(string $id): bool
    {
        return $this->getDataById($id);
    }

    /**
     * Saves the changes made to the active record.
     *
     * @return bool
     */
    public function save(): bool
    {
        $values = [];
        // We create separate arrays with the modified fields
        foreach ($this->newData as $field => $data) {
            // The first condition is to prevent nulls from becoming empty strings
            if ((!isset($this->oldData[$field]) && isset($this->newData['field'])) || $this->newData[$field] !== $this->oldData[$field]) {
                $values[$field] = $data;
            }
        }

        // If there are no modifications, we leave without error.
        if (count($values) === 0) {
            return true;
        }

        // Insert or update the data as appropriate (insert if $this->id == '')
        $ret = ($this->id == '') ? $this->insertRecord($values) : $this->updateRecord($values);
        if ($ret) {
            $this->id = $this->newData[$this->idField] ?? null;
            $this->oldData = $this->newData;
        }
        return $ret;
    }

    /**
     * Insert a new record.
     * $fields is an array of fields and $values an array with the values for each field in the same order.
     *
     * @param array $values
     *
     * @return bool
     */
    private function insertRecord($values): bool
    {
        $fieldNames = [];
        $fieldVars = [];
        $vars = [];

        foreach ($values as $fieldName => $value) {
            $fieldNames[$fieldName] = Database::getInstance()->getSqlHelper()->quoteFieldName($fieldName);
            $fieldVars[$fieldName] = ':' . $fieldName;
            $vars[$fieldName] = $value;
        }

        $fieldList = implode(', ', $fieldNames);
        $valueList = implode(', ', $fieldVars);

        $sql = "INSERT INTO {$this->getQuotedTableName()} ($fieldList) VALUES ($valueList);";

        $ret = Database::getInstance()->getDbEngine()->exec($sql, $vars);

        // Assign the value of the primary key of the newly inserted record
        $this->id = Database::getInstance()->getDbEngine()->getLastInserted();
        return $ret;
    }

    /**
     * Update the modified fields in the active record.
     * $data is an array of assignments of type field=value.
     *
     * @param array $data
     *
     * @return bool
     */
    private function updateRecord(array $data): bool
    {
        $fieldNames = [];
        $vars = [];
        foreach ($data as $fieldName => $value) {
            $fieldNames[] = Database::getInstance()->getSqlHelper()->quoteFieldName($fieldName) . " = :" . $fieldName;
            $vars[$fieldName] = $value;
        }

        $fieldList = implode(', ', $fieldNames);

        $idField = Database::getInstance()->getSqlHelper()->quoteFieldName($this->idField);
        $sql = "UPDATE {$this->getQuotedTableName()} SET {$fieldList} WHERE {$idField} = :id;";
        $vars['id'] = $this->id;

        return Database::getInstance()->getDbEngine()->exec($sql, $vars);
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
