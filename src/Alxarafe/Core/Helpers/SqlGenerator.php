<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Helpers;

/**
 * SqlGenerator builds default SQL expressions from table and view yaml files
 */
class SqlGenerator
{
    private $fields;
    private $viewData;

    /**
     * SqlGenerator constructor.
     *
     * @param      $fields
     * @param null $viewData
     */
    public function __construct($fields, $viewData = null)
    {
        $this->fields = $fields;
        $this->viewData = $viewData;
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
    }

    /**
     * Return the main part of the search SQL query.
     * TODO: Must return LEFT JOIN with related tables
     *
     * @param string $query
     * @param array  $columns
     *
     * @return string
     */
    public function searchQuery($query, $columns = [])
    {
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
    }

    public function getRelatedInfo()
    {
        $viewdata = Schema::getFromYamlFile($this->tableName, 'viewdata');
        if (!isset($viewdata['fields'])) {
            return '';
        }
        $dataset = [];
        foreach ($viewdata['fields'] as $field => $data) {
            dump($field);
            dump($data);
            dump($this->fields);
            if (isset($data['dataset']) && $data['dataset'] !== $this->tableName) {
                $dataset[$data['dataset']][] = [
                    'resultfieldname' => $field,
                    'fieldname' => $data['fieldname'],
                    'referencedtable' => $this->fields[$data['fieldname']]['referencedtable'],
                    'referencedfield' => $this->fields[$data['fieldname']]['referencedfield'],
                ];
            }
        }
        dump($dataset);

        /*
        foreach ($this->fields as $field => $data) {
            if (!is_null($data['referencedtable'])) {
                $sqlView .= ' LEFT JOIN ' . self::quoteTableName($quotedTableName, true)
                    . " ON {$quotedTableName}." . self::quoteFieldName($indexData['column']) . ' = '
                    . self::quoteTableName($indexData['referencedtable'], true) . '.' . self::quoteFieldName($primaryColumn[$indexName]);
            }
        }
        */
    }
}
