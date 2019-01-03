<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Database\SqlHelpers;

use Alxarafe\Database\SqlHelper;
use Alxarafe\Helpers\Config;

/**
 * Personalization of SQL queries to use MySQL.
 */
class SqlMySql extends SqlHelper
{

    /**
     * SqlMySql constructor.
     */
    public function __construct()
    {
        $this->tableQuote = '`';
        $this->fieldQuote = '`';
    }

    /**
     * Returns an array with the name of all the tables in the database.
     *
     * @return array
     */
    public function getTables(): array
    {
        $query = 'SHOW TABLES';
        return $this->flatArray(Config::$dbEngine->select($query));
    }

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
     * @return array
     */
    public function getColumns(string $tableName): array
    {
        /**
         * array (size=6)
         * 'Field' => string 'id' (length=2)
         * 'Type' => string 'int(10) unsigned' (length=16)
         * 'Null' => string 'NO' (length=2)
         * 'Key' => string 'PRI' (length=3)
         * 'Default' => null
         * 'Extra' => string 'auto_increment' (length=14)
         */
        return 'SHOW COLUMNS FROM ' . $this->quoteTableName($tableName) . ';';
    }

    /**
     * TODO: Undocumented
     *
     * @param string $tableName
     *
     * @return string
     */
    public function getIndexes(string $tableName): string
    {
        // https://stackoverflow.com/questions/5213339/how-to-see-indexes-for-a-database-or-table-in-mysql

        return 'SHOW INDEX FROM ' . Config::$sqlHelper->quoteTableName($tableName);
    }

    /**
     * TODO: Undocumented
     *
     * @param string $tableName
     *
     * @return string
     */
    public function getConstraints(string $tableName): string
    {
        /*
         * https://stackoverflow.com/questions/5094948/mysql-how-can-i-see-all-constraints-on-a-table/36750731
         *
         * select COLUMN_NAME, CONSTRAINT_NAME, REFERENCED_COLUMN_NAME, REFERENCED_TABLE_NAME
         * from information_schema.KEY_COLUMN_USAGE
         * where TABLE_NAME = 'table to be checked';
         */
    }
}
