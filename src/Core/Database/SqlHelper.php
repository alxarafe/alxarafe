<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Database;

use Alxarafe\Helpers\Config;

/**
 * Engine provides generic support for databases.
 * The class will have to be extended by completing the particularities of each of them.
 */
abstract class SqlHelper
{

    /**
     * Character used as quotes to enclose the name of the table
     *
     * @var string
     */
    protected $tableQuote;

    /**
     * Character used as quotes to enclose the name of a field
     *
     * @var string
     */
    protected $fieldQuote;

    /**
     * Character used as quotes to enclose the literal fields
     *
     * @var string
     */
    protected $literalQuote;

    /**
     * It contains an associative array in which each index is a type of virtual
     * field, and its content is each of the types it represents.
     *
     * @var array
     */
    protected $fieldTypes;

    /**
     * SqlHelper constructor.
     */
    public function __construct()
    {
        $this->tableQuote = '';
        $this->fieldQuote = '';
        $this->literalQuote = '"';
        $this->fieldTypes = [];
    }

    /**
     * Returns the name of the table in quotes.
     *
     * @param string $tableName
     * @param bool   $usePrefix
     *
     * @return string
     */
    public function quoteTableName(string $tableName, bool $usePrefix = true): string
    {
        return $this->tableQuote .
            ($usePrefix ? Config::getVar('dbPrefix') : '') .
            $tableName . $this->tableQuote;
    }

    /**
     * Returns the name of the field in quotes.
     *
     * @param string $fieldName
     *
     * @return string
     */
    public function quoteFieldName(string $fieldName): string
    {
        return Config::$sqlHelper->fieldQuote . $fieldName . Config::$sqlHelper->fieldQuote;
    }

    /**
     * Returns the name of the field in quotes.
     *
     * @param string $fieldName
     *
     * @return string
     */
    public function quoteLiteral(string $fieldName): string
    {
        return Config::$sqlHelper->literalQuote . $fieldName . Config::$sqlHelper->literalQuote;
    }

    /**
     * Returns an array with the name of all the tables in the database.
     *
     * @return array
     */
    abstract public function getTables(): array;

    /**
     * Returns an array with all the columns of a table
     *
     * TODO: Review the types. The variants will depend on type + length.
     *
     * 'name_of_the_field' => {
     *  (Required type and length or bytes)
     *      'type' => (string/integer/float/decimal/boolean/date/datetime/text/blob)
     *      'length' => It is the number of characters that the field needs (optional if bytes exists)
     *      'bytes' => Number of bytes occupied by the data (optional if length exists)
     *  (Optional)
     *      'default' => Default value
     *      'nullable' => True if it can be null
     *      'primary' => True if it is the primary key
     *      'autoincrement' => True if it is an autoincremental number
     *      'zerofilled' => True if it completes zeros on the left
     * }
     *
     * @param string $tableName
     *
     * @return array
     */
    public function getColumns(string $tableName, bool $usePrefix = true): array
    {
        $query = $this->getColumnsSql($tableName, $usePrefix);
        $data = Config::$dbEngine->select($query);
        $result = [];
        foreach ($data as $value) {
            $row = $this->normalizeFields($value);
            $result[$row['field']] = $row;
        }
        return $result;
    }

    /**
     * SQL statement that returns the fields in the table
     *
     * @param string $tableName
     *
     * @return string
     */
    abstract public function getColumnsSql(string $tableName, bool $usePrefix): string;

    /**
     * Modifies the structure returned by the query generated with
     * getColumnsSql to the normalized format that returns getColumns
     *
     * @param array $fields
     *
     * @return array
     */
    abstract public function normalizeFields(array $fields): array;

    //abstract public function normalizeConstraints(array $fields): array;

    public function getIndexes(string $tableName, bool $usePrefix): array
    {
        $query = $this->getIndexesSql($tableName, $usePrefix);
        $data = Config::$dbEngine->select($query);
        $result = [];
        foreach ($data as $value) {
            $row = $this->normalizeIndexes($value);
            $result[$row['index']] = $row;
        }

        return $result;
    }

    /**
     * TODO: Undocumented
     *
     * @param string $tableName
     *
     * @return string
     */
    abstract public function getIndexesSql(string $tableName, bool $usePrefix = true): string;

    abstract public function normalizeIndexes(array $fields): array;

    /**
     * TODO: Undocumented
     *
     * @param string $tableName
     *
     * @return string
     */
    abstract public function getConstraintsSql(string $tableName, bool $usePrefix = true): string;

    /*
    public function getConstraints(string $tableName): array
    {
        $query = $this->getConstraintsSql($tableName);
        $data = Config::$dbEngine->select($query);
        $result = [];
        foreach ($data as $value) {
            $row = $this->normalizeConstraints($value);
            $result[$row['constraint']] = $row;
        }

        return $result;
    }
    */
}
