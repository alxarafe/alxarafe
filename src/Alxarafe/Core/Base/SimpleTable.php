<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Base;

use Alxarafe\Core\Providers\Database;

/**
 * Class SimpleTable has all the basic methods to access and manipulate information, but without modifying its
 * structure.
 */
class SimpleTable extends FlatTable
{
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
    public function getAllRecordsPaged(int $offset = 0, int $limit = DEFAULT_ROWS_PER_PAGE): array
    {
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
     *
     * @deprecated Use SqlGenerator instead.
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
     * TODO: Must return LEFT JOIN with related tables. See @param string $query
     *
     * @param array $columns
     *
     * @return string
     *
     * @deprecated .
     *
     * @deprecated Use SqlGenerator instead.
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
}
