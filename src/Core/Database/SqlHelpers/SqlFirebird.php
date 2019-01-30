<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Database\SqlHelpers;

use Alxarafe\Database\SqlHelper;
use Alxarafe\Helpers\Config;
use Alxarafe\Helpers\Debug;
use Alxarafe\Helpers\Utils;

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
        parent::__construct();

        $this->tableQuote = '\'';
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
        return strtoupper(parent::quoteLiteral($fieldName));
    }

    /**
     * Returns an array with the name of all the tables in the database.
     *
     * @return array
     */
    public function getTables(): array
    {
        // http://www.firebirdfaq.org/faq174/
        $query = 'SELECT RDB$RELATION_NAME
                  FROM RDB$RELATIONS
                  WHERE RDB$VIEW_BLR IS NULL AND (RDB$SYSTEM_FLAG IS NULL OR RDB$SYSTEM_FLAG = 0);';
        return Utils::flatArray(Config::$dbEngine->select($query));
    }

    /**
     * SQL statement that returns the fields in the table
     *
     * @param string $tableName
     *
     * @return string
     */
    public function getColumnsSql(string $tableName, bool $usePrefix): string
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
            b.RDB$RELATION_NAME = ' . $this->quoteTableName($tableName, $usePrefix) . '
        ORDER BY b.RDB$FIELD_POSITION;'; // ORDER BY a.RDB$RELATION_NAME, b.RDB$FIELD_ID
    }

    /**
     * Returns the name of the table in quotes.
     *
     * @param string $tableName
     *
     * @return string
     */
    public function quoteTableName(string $tableName, $usePrefix = true): string
    {
        return strtoupper(parent::quoteTableName($tableName, $usePrefix));
    }

    /**
     * Modifies the structure returned by the query generated with getColumnsSql to the normalized format that returns
     * getColumns
     *
     * @param array $row
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
                $result['type'] = trim($row['type']);
                Debug::addMessage('Deprecated', "Correct the data type '" . $result['type'] . "' in Firebird database");
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
     * @param array $fields
     *
     * @return array
     */
    public function normalizeIndexes(array $fields): array
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
     * Obtain an array with the basic information about the indexes of the table, which will be supplemented with the
     * restrictions later.
     *
     * @doc https://stackoverflow.com/questions/5213339/how-to-see-indexes-for-a-database-or-table-in-mysql
     *
     * @param string $tableName
     * @param bool   $usePrefix
     *
     * @return string
     */
    public function getIndexesSql(string $tableName, bool $usePrefix = true): string
    {
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
     * @param array $fields
     *
     * @return array
     */
    public function normalizeConstraints(array $fields): array
    {
        $result = [];
        $result['table'] = $fields['TABLE_NAME'];
        $result['column'] = $fields['COLUMN_NAME'];
        $result['constraint'] = $fields['CONSTRAINT_NAME'];
        $result['referencedtable'] = $fields['REFERENCED_TABLE_NAME'];
        $result['referencedfield'] = $fields['REFERENCED_COLUMN_NAME'];
        return $result;
    }

    /**
     * TODO: Undocumented and pending complete.
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
     * Returns the views from the database.
     *
     * @doc http://www.firebirdfaq.org/faq174/
     *
     * @return string
     */
    public function getViewsSql(): string
    {
        return 'SELECT RDB$RELATION_NAME FROM RDB$RELATIONS WHERE RDB$VIEW_BLR IS NOT NULL AND (RDB$SYSTEM_FLAG IS NULL OR RDB$SYSTEM_FLAG = 0);';
    }

    /**
     *
     * Esta consulta funciona... Para tomarla como modelo.
     * Está pendiente de crear un AUTO_INCREMENT
     *
     * https://firebirdsql.org/refdocs/langrefupd15-create-table.html
     *
     *
     * CREATE TABLE people (
     * id integer NOT NULL PRIMARY KEY,
     * name varchar(50) NOT NULL,
     * id_fiscal varchar(10) NOT NULL,
     * age integer NOT NULL
     * );
     * CREATE INDEX person_name ON people(name);
     * ALTER TABLE people ADD CONSTRAINT person_id_fiscal UNIQUE INDEX (id_fiscal);
     * INSERT INTO people
     * (id, name, id_fiscal, age)
     * VALUES
     * ('1', 'Person 1', '11111111X', '21'),
     * ('2', 'Person 2', '22222222Y', '32'),
     * ('3', 'Person 3', '33333333Z', '43');
     */

    /**
     * TODO: Undocumented and pending complete.
     *
     * @param string $tableName
     *
     * @return string
     */
    public function getConstraintsSql(string $tableName, bool $usePrefix = true): string
    {
        // TODO: Implement getConstraintsSql() method.
        return '';
    }

    /**
     * TODO: Undocummented.
     *
     * @param string $fieldName
     * @param array  $data
     *
     * @return string
     */
    public function getSQLField(string $fieldName, array $data): string
    {
        return '';
    }

    /**
     * Returns if table exists in the database.
     *
     * @param string $tableName
     *
     * @return bool
     */
    public function tableExists(string $tableName): string
    {
        // TODO: Implement tableExists() method.
        return '';
    }
}
