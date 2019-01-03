<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Database\SqlHelpers;

use Alxarafe\Database\SqlHelper;

/**
 * Personalization of SQL queries to use Firebird.
 */
class SqlFirebird extends SqlHelper
{

    /**
     * SqlFirebird constructor.
     */
    public function __construct()
    {
        $this->tableQuote = '\'';
        $this->fieldQuote = '';
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
        return strtoupper(parent::quoteTablename($tableName));
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
        return strtoupper(parent::quoteFieldname($fieldName));
    }

    /**
     * Returns an array with the name of all the tables in the database.
     *
     * @return array
     */
    public function getTables(): array
    {
        // http://www.firebirdfaq.org/faq174/
        $query = 'select rdb$relation_name from rdb$relations where rdb$view_blr is null and (rdb$system_flag is null or rdb$system_flag = 0);';
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
        return 'SELECT
            b.RDB$FIELD_NAME as Field,
            d.RDB$TYPE_NAME as Type,
            c.RDB$FIELD_LENGTH as Length,
            b.RDB$DEFAULT_SOURCE AS DefaultSource,
            b.RDB$DEFAULT_VALUE AS What,
            b.RDB$NULL_FLAG AS NullValue
        FROM RDB$RELATIONS a
        INNER JOIN RDB$RELATION_FIELDS b ON a.RDB$RELATION_NAME = b.RDB$RELATION_NAME
        INNER JOIN RDB$FIELDS c ON b.RDB$FIELD_SOURCE = c.RDB$FIELD_NAME
        INNER JOIN RDB$TYPES d ON c.RDB$FIELD_TYPE = d.RDB$TYPE
        WHERE
            a.RDB$SYSTEM_FLAG = 0 AND
            d.RDB$FIELD_NAME = \'RDB$FIELD_TYPE\' AND
            b.RDB$RELATION_NAME=' . $this->quoteTableName($tableName) . '
        ORDER BY b.RDB$FIELD_POSITION;'; // ORDER BY a.RDB$RELATION_NAME, b.RDB$FIELD_ID
    }

    /**
     * TODO: Undocumented
     *
     * @return string
     */
    public function getViews(): string
    {
        // http://www.firebirdfaq.org/faq174/
        return 'select rdb$relation_name from rdb$relations where rdb$view_blr is not null and (rdb$system_flag is null or rdb$system_flag = 0);';
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
    /**
     *
     * Esta consulta funciona... Para tomarla como modelo.
     * Está pendiente de crear un AUTO_INCREMENT
     *
     * https://firebirdsql.org/refdocs/langrefupd15-create-table.html
     *

      CREATE TABLE people (
      id integer NOT NULL PRIMARY KEY,
      name varchar(50) NOT NULL,
      id_fiscal varchar(10) NOT NULL,
      age integer NOT NULL
      );
      CREATE INDEX person_name ON people(name);
      ALTER TABLE people ADD CONSTRAINT person_id_fiscal UNIQUE INDEX (id_fiscal);
      INSERT INTO people
      (id, name, id_fiscal, age)
     * VALUES
      ('1', 'Person 1', '11111111X', '21'),
      ('2', 'Person 2', '22222222Y', '32'),
      ('3', 'Person 3', '33333333Z', '43');
     */
}
