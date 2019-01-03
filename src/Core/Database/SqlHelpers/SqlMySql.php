<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Database\SqlHelpers;

use Alxarafe\Database\SqlHelper;
use Alxarafe\Helpers\Config;
use Alxarafe\Helpers\Debug;

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
        $this->fieldQuote = '"';
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
     * SQL statement that returns the fields in the table
     *
     * @param string $tableName
     *
     * @return string
     */
    public function getColumnsSql(string $tableName): string
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
     * Divide the data type of a MySQL field into its various components: type,
     * length, unsigned or zerofill, if applicable.
     *
     * @param string $originalType
     *
     * @return array
     */
    private static function splitType(string $originalType): array
    {
        $explode = explode(' ', strtolower($originalType));

        $pos = strpos($explode[0], '(');

        $type = $pos ? substr($explode[0], 0, $pos) : $explode[0];
        $length = $pos ? intval(substr($explode[0], $pos + 1)) : null;

        $pos = array_search('unsigned', $explode);
        $unsigned = $pos ? 'unsigned' : null;

        $pos = array_search('zerofill', $explode);
        $zerofill = $pos ? 'zerofill' : null;

        $pos = array_search('zerofill', $explode);
        $zerofill = $pos ? 'zerofill' : null;

        return ['type' => $type, 'length' => $length, 'unsigned' => $unsigned, 'zerofill' => $zerofill];
    }

    /**
     * Modifies the structure returned by the query generated with
     * getColumnsSql to the normalized format that returns getColumns
     *
     * @param array $fields
     *
     * @return array
     */
    public function normalizeFields(array $row): array
    {
        $result = [];
        $result['field'] = $row['Field'];
        $type = $this->splitType($row['Type']);
        switch ($type['type']) {
            // Integers
            case 'int':
            case 'tinyint':
                $result['type'] = 'integer';
                break;
            // String
            case 'varchar':
                $result['type'] = 'string';
                break;
            case 'double':
                $result['type'] = 'float';
                break;
            case 'date':
                $result['type'] = 'date';
                break;
            case 'datetime':
                $result['type'] = 'datetime';
                break;
            default:
                // Others
                $result['type'] = $type['type'];
                Debug::addMessage('Deprecated', 'Correct the data type ' . $type['type'] . ' in MySql database');
        }
        $result['length'] = $type['length'] ?? null;
        $result['default'] = $row['Default'] ?? null;
        $result['nullable'] = $row['Null'];
        $result['primary'] = $row['Key'];
        $result['autoincrement'] = $row['Extra'] == 'auto_increment' ? 1 : 0;

        return $result;
    }

    /**
     * TODO: Undocumented
     *
     * @param string $tableName
     *
     * @return string
     */
    public function getIndexesSql(string $tableName): string
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
    public function getConstraintsSql(string $tableName): string
    {
        return 'SELECT TABLE_NAME,
       COLUMN_NAME,
       CONSTRAINT_NAME,
       REFERENCED_TABLE_NAME,
       REFERENCED_COLUMN_NAME
FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
WHERE TABLE_SCHEMA = ' . $this->quoteFieldName(Config::getVar('dbName')) . '
      AND TABLE_NAME = ' . $this->quoteFieldName($tableName) . '
      AND REFERENCED_COLUMN_NAME IS NOT NULL;';
        /*
         * https://stackoverflow.com/questions/5094948/mysql-how-can-i-see-all-constraints-on-a-table/36750731
         *
         * select COLUMN_NAME, CONSTRAINT_NAME, REFERENCED_COLUMN_NAME, REFERENCED_TABLE_NAME
         * from information_schema.KEY_COLUMN_USAGE
         * where TABLE_NAME = 'table to be checked';
         */
    }
}
