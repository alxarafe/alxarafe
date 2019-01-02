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
     * @return string
     */
    public function getTables(): string
    {
        // Config::$global['dbName']
        //return Config::$dbEngine->select('SHOW COLUMNS FROM '.self::quoteTablename($tableName));
        return 'SHOW TABLES';
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

        return 'SHOW INDEX FROM ' . Config::$sqlHelper->quoteTablename($tableName);
    }

    /**
     * TODO: Undocumented
     *
     * @param string $tableName
     *
     * @return string
     */
    public function getColumns(string $tableName): string
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
        return 'SHOW COLUMNS FROM ' . $this->quoteTablename($tableName) . ';';
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
