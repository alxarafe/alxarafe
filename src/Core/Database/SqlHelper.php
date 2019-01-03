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
     * SqlHelper constructor.
     */
    public function __construct()
    {
        $this->tableQuote = '';
        $this->fieldQuote = '';
    }

    /**
     * Flatten an array to leave it at a single level.
     * Ignore the value of the indexes of the array, taking only the values.
     * Remove spaces from the result and convert it to lowercase.
     *
     * @param array $array
     * @return array
     */
    static protected function flatArray(array $array): array
    {
        $ret = [];
        foreach ($array as $value) {
            if (is_array($value)) {
                // We expect that the indexes will not overlap
                $ret = array_merge($ret, self::flatArray($value));
            } else {
                $ret[] = strtolower(trim($value));
            }
        }
        return $ret;
    }

    /**
     * Returns the name of the table in quotes.
     *
     * @param string $tableName
     *
     * @return string
     */
    public function quoteTablename(string $tableName): string
    {
        return $this->tableQuote . $tableName . $this->tableQuote;
    }

    /**
     * Returns the name of the field in quotes.
     *
     * @param string $fieldName
     *
     * @return string
     */
    public function quoteFieldname(string $fieldName): string
    {
        return Config::$sqlHelper->fieldQuote . $fieldName . Config::$sqlHelper->fieldQuote;
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
     *  (Requiered)
     *      'type' => (string/integer/float/decimal/boolean/date/datetime/text/blob)
     *      'length' => It is the number of characters that the field needs
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
     * @return string
     */
    abstract public function getColumns(string $tableName): array;

    /**
     * TODO: Undocumented
     *
     * @param string $tableName
     *
     * @return string
     */
    abstract public function getIndexes(string $tableName): string;

    /**
     * TODO: Undocumented
     *
     * @param string $tableName
     *
     * @return string
     */
    abstract public function getConstraints(string $tableName): string;
}
