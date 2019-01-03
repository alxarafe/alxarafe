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

    public function __construct()
    {
        $this->tableQuote = '\'';
        $this->fieldQuote = '';
    }

    public function quoteTablename(string $tablename): string
    {
        return strtoupper(parent::quoteTablename($tablename));
    }

    public function quoteFieldname(string $fieldname): string
    {
        return strtoupper(parent::quoteFieldname($tablename));
    }

    public function getTables(): string
    {
        // http://www.firebirdfaq.org/faq174/
        return 'select rdb$relation_name from rdb$relations where rdb$view_blr is null and (rdb$system_flag is null or rdb$system_flag = 0);';
    }

    public function getViews(): string
    {
        // http://www.firebirdfaq.org/faq174/
        return 'select rdb$relation_name from rdb$relations where rdb$view_blr is not null and (rdb$system_flag is null or rdb$system_flag = 0);';
    }

    public function getColumns(string $tablename): string
    {


        return '
SELECT
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
	b.RDB$RELATION_NAME=' . $this->quoteTablename($tablename) . '
ORDER BY b.RDB$FIELD_POSITION;
'; // ORDER BY a.RDB$RELATION_NAME, b.RDB$FIELD_ID

        return 'select rdb$field_name from rdb$relation_fields where rdb$relation_name=' . $this->quoteTablename($tablename) . ';';
    }

    public function getIndexes(string $tablename): string
    {
        // https://stackoverflow.com/questions/5213339/how-to-see-indexes-for-a-database-or-table-in-mysql

        return 'SHOW INDEX FROM ' . Config::$sqlHelper->quoteTablename($tablaname);
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
