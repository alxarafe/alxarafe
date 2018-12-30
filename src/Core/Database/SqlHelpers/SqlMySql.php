<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Database\SqlHelpers;

use Alxarafe\Database\SqlHelper;

/**
 * Personalization of SQL queries to use MySQL.
 */
class SqlMySql extends SqlHelper
{

    public function __construct()
    {
        $this->tableQuote = '`';
        $this->fieldQuote = '`';
    }
    public function getTables(): string
    {
        // Config::$global['dbName']
        //return Config::$dbEngine->select('SHOW COLUMNS FROM '.self::quoteTablename($tablaname));
        return 'SHOW TABLES';
    }

    public function getIndexes(string $tablename): string
    {
        // https://stackoverflow.com/questions/5213339/how-to-see-indexes-for-a-database-or-table-in-mysql

        return 'SHOW INDEX FROM ' . Config::$sqlHelper->quoteTablename($tablaname);
    }

    public function getColumns(string $tablename): string
    {
        return 'SHOW COLUMNS FROM ' . $this->quoteTablename($tablename) . ';';
    }

    public function getConstraints(string $tablename): string
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
