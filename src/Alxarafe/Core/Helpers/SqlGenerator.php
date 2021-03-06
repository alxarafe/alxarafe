<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Helpers;

use Alxarafe\Core\Base\Table;
use Alxarafe\Core\Models\TableModel;
use Alxarafe\Core\Providers\Database;

/**
 * SqlGenerator builds default SQL expressions from table and view yaml files
 */
class SqlGenerator
{
    /**
     * Contains an array of used models.
     *
     * @var array
     */
    protected $models;
    /**
     * Name of the main table.
     *
     * @var string
     */
    private $tablename;
    /**
     * May contain an array with the viewData info for the view.
     *
     * @var array|null
     */
    private $viewData;

    /**
     * SqlGenerator constructor.
     *
     * @param string     $tablename
     * @param array|null $viewData
     */
    public function __construct(string $tablename, array $viewData = null)
    {
        $this->tablename = $tablename;
        $this->viewData = $viewData;
        $this->models = [];
        $this->models[$tablename] = new Table($tablename);
        foreach ($this->viewData as $data) {
            if (!isset($models[$data['dataset']])) {
                $this->models[$data['dataset']] = new Table($data['dataset']);
            }
        }
    }

    public function getModel($name)
    {
        return $this->models[$name] ?? null;
    }

    /**
     * Realize the search to database table.
     *
     * @param array $data
     * @param int   $recordsFiltered
     * @param array $requestData
     */
    public function searchData(array &$data, int &$recordsFiltered, array $requestData = []): void
    {
        // Page to start
        $offset = $requestData['start'] ?? 0;
        // Columns used un table by order
        $columns = $this->getDefaultColumnsSearch();
        // Remove this extra column for search (not in table)
        if (in_array('col-action', $columns, true)) {
            unset($columns[array_search('col-action', $columns, true)]);
        }
        // Order
        $order = '';
        if (isset($columns[$requestData['order'][0]['column']])) {
            $order = $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'];
        }
        // Default data
        $recordsTotal = $this->models[$this->tablename]->countAllRecords();
        // All registers in the actual page
        $recordsFiltered = $recordsTotal;
        if (!empty($requestData['search']['value'])) {
            // Data for this search
            $search = $requestData['search']['value'];
            $data = $this->search($search, $columns, $offset, $order);
            $recordsFiltered = $this->searchCount($this->tablename, $search, $columns);
        } else {
            $search = '';
            $data = $this->search($search, $columns, $offset, $order);
        }
    }

    /**
     * Return a default list of col.
     *
     * @return array
     */
    public function getDefaultColumnsSearch(): array
    {
        $list = [];
        $i = 0;
        foreach ($this->viewData['fields'] as $key => $value) {
            $list[$i] = $key;
            $i++;
        }
        $list[$i] = 'col-action';
        return $list;
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
    public function searchQuery($query, $columns = [])
    {
        $fillColumns = false;
        if (empty($columns)) {
            $fillColumns = true;
        }
        $table = Schema::getFromYamlFile($this->tablename);

        $primaryColumn = [];
        $nameColumn = [];
        // $tabla = Database::getInstance()->getDbEngine()->getDbTableStructure($tableName);
        $fields = $table['fields'];
        $indexes = $table['indexes'];

        // Ignore indexes that aren't constraints
        foreach ($indexes as $indexName => $indexData) {
            if (isset($indexData['constraint'])) {
                $refTable = (new TableModel())->get($indexData['referencedtable']);
                $newClass = $refTable->namespace;
                if (!empty($newClass)) {
                    $class = new $newClass();
                    // $tableNameIndex = $refTable->tablename;
                    // $tableIndex[$indexName] = Database::getInstance()->getDbEngine()->getDbTableStructure($tableNameIndex);
                    $primaryColumn[$indexName] = $table['indexes']['PRIMARY']['column'];
                    $nameColumn[$indexName] = $class->getNameField();
                } else {
                    // throw new RuntimeException(
                    //     "Model class for table '" . $indexData['referencedtable'] . "' not loaded. Do you forgot to add 'getDependencies()' to model for '" . $tableName . "' table'."
                    // );
                }
            } else {
                unset($indexes[$indexName]);
            }
        }

        $quotedTableName = SchemaDB::quoteTableName($this->tablename, true);
        $sqlView = "SELECT ";
        $sep = '';
        foreach ($fields as $fieldName => $fieldData) {
            if (!is_null($fieldName)) {
                $columns[] = $fillColumns ? $quotedTableName . '.' . SchemaDB::quoteFieldName($fieldName) : '';
                $sqlView .= "{$sep}{$quotedTableName}." . SchemaDB::quoteFieldName($fieldName);
                $sep = ', ';
            }
        }
        foreach ($indexes as $indexName => $indexData) {
            if (!is_null($nameColumn[$indexName])) {
                $sqlView .= $sep . SchemaDB::quoteTableName($indexData['referencedtable'], true) . '.' . SchemaDB::quoteFieldName($nameColumn[$indexName])
                    . " AS {$indexData['referencedtable']}_{$nameColumn[$indexName]}";
                $sep = ', ';
            }
        }
        $sqlView .= " FROM {$quotedTableName}";
        foreach ($indexes as $indexName => $indexData) {
            if (!is_null($indexData['column']) && !is_null($primaryColumn[$indexName])) {
                $sqlView .= ' LEFT JOIN ' . SchemaDB::quoteTableName($indexData['referencedtable'], true)
                    . " ON {$quotedTableName}." . SchemaDB::quoteFieldName($indexData['column']) . ' = '
                    . SchemaDB::quoteTableName($indexData['referencedtable'], true) . '.' . SchemaDB::quoteFieldName($primaryColumn[$indexName]);
            }
        }

        $query = str_replace(' ', '%', $query);

        $sep = '';
        if (!empty($columns) && !empty($query)) {
            $sqlView .= ' WHERE (';
            foreach ($columns as $pos => $fieldName) {
                if ($fieldName !== null && $fieldName !== 'col-action') {
                    $sqlView .= $sep . "lower({$fieldName}) LIKE '%" . $query . "%'";
                    $sep = ' OR ';
                }
            }
            $sqlView .= ')';
        }

        $sqlView .= ';';
        return $sqlView;
    }

    /**
     * Do a search to a table.
     * Returns the result per page.
     *
     * @param string $tableName
     * @param string $query   What to look for
     * @param array  $columns For example: [0 => 'name']
     *
     * @return int
     */
    public function searchCount(string $tableName, string $query, array $columns = []): int
    {
        $sql = $this->searchQuery($query, $columns);
        $idField = $this->models[$tableName]->getIdField();
        $idField = Database::getInstance()->getSqlHelper()->quoteFieldName($idField);
        $sql = str_replace('SELECT ', "SELECT COUNT({$idField}) AS total, ", $sql);
        $data = Database::getInstance()->getDbEngine()->select($sql);
        return empty($data) ? 0 : (int) $data[0]['total'];
    }
}
