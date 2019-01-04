<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Database\SqlHelpers;

use Alxarafe\Database\SqlHelper;
use Alxarafe\Helpers\Utils;
use Alxarafe\Helpers\Config;

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
    public function quoteTableName(string $tableName): string
    {
        return strtoupper(parent::quoteTableName($tableName));
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
        return strtoupper(parent::quoteFieldName($fieldName));
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
        return Utils::flatArray(Config::$dbEngine->select($query));
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
        return 'SELECT
            b.RDB$FIELD_NAME as field,
            d.RDB$TYPE_NAME as type,
            c.RDB$FIELD_LENGTH as length,
            b.RDB$NULL_FLAG AS nullable,
            b.RDB$DEFAULT_SOURCE AS defaultsource,
            b.RDB$DEFAULT_VALUE AS What
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
        $result['field'] = strtolower(trim($row['field']));
        switch (trim($row['type'])) {
            // Integers
            case 'LONG':
                $result['type'] = 'integer';
                $result['bytes'] = $row['length'];
                break;
            // String
            case 'VARYING':
                $result['type'] = 'string';
                $result['length'] = $row['length'];
                break;
            default:
                // Others
                $result['type'] = trim($value['type']);
                Debug::addMessage('Deprecated', "Correct the data type '$type' in Firebird database");
        }
        $result['default'] = isset($row['defaultsource']) ? substr($row['defaultsource'], 10) : null;
        $result['nullable'] = $row['nullable'];
        $result['primary'] = 0;
        $result['autoincrement'] = 0;

        return $result;
    }
    /**
     * uniqueConstraints:
     *      TC_ARTICULOS_CODIGO_U:
     *          columns:
     *              - CODIGOARTICULO
     * indexes:
     *      FK_ARTICULO_PORCENTAJEIMPUESTO:
     *          columns:
     *              - IDPORCENTAJEIMPUESTO
     *
     *
     *
     * @param array $row
     * @return array
     */
    public function normalizeIndexes(array $row): array
    {
        $result = [];
        /*
          $result['table'] = $row['TABLE_NAME'];
          $result['column'] = $row['COLUMN_NAME'];
          $result['constraint'] = $row['CONSTRAINT_NAME'];
          $result['referencedtable'] = $row['REFERENCED_TABLE_NAME'];
          $result['referencedfield'] = $row['REFERENCED_COLUMN_NAME'];
         */
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
     * 'TABLE_NAME' => string 'clientes' (length=8)
     * 'COLUMN_NAME' => string 'codgrupo' (length=8)
     * 'CONSTRAINT_NAME' => string 'ca_clientes_grupos' (length=18)
     * 'REFERENCED_TABLE_NAME' => string 'gruposclientes' (length=14)
     * 'REFERENCED_COLUMN_NAME' => string 'codgrupo' (length=8)
     *
     * ALTER TABLE Orders ADD CONSTRAINT FK_PersonOrder FOREIGN KEY (PersonID) REFERENCES Persons(PersonID);
     *
     * @param array $row
     * @return array
     */
    public function normalizeConstraints(array $row): array
    {
        $result = [];
        $result['table'] = $row['TABLE_NAME'];
        $result['column'] = $row['COLUMN_NAME'];
        $result['constraint'] = $row['CONSTRAINT_NAME'];
        $result['referencedtable'] = $row['REFERENCED_TABLE_NAME'];
        $result['referencedfield'] = $row['REFERENCED_COLUMN_NAME'];
        return $result;
    }

    /**
     * TODO: Undocumented
     *
     * @param string $tableName
     *
     * @return string
     */
    /*
      public function getConstraintsSql(string $tableName): string
      {
      /*
     * https://stackoverflow.com/questions/5094948/mysql-how-can-i-see-all-constraints-on-a-table/36750731
     *
     * select COLUMN_NAME, CONSTRAINT_NAME, REFERENCED_COLUMN_NAME, REFERENCED_TABLE_NAME
     * from information_schema.KEY_COLUMN_USAGE
     * where TABLE_NAME = 'table to be checked';
     * /
      }
     */

    /**
     * TODO: Undocumented
     *
     * @return string
     */
    public function getViewsSql(): string
    {
        // http://www.firebirdfaq.org/faq174/
        return 'select rdb$relation_name from rdb$relations where rdb$view_blr is not null and (rdb$system_flag is null or rdb$system_flag = 0);';
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
