<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Database\SqlHelpers;

use Alxarafe\Core\Database\SqlHelper;
use Alxarafe\Core\Helpers\Utils\ArrayUtils;
use Alxarafe\Core\Providers\Database;

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
        $this->fieldTypes = [
            'integer' => ['int', 'tinyint'],
            'decimal' => ['decimal'],
            'string' => ['char', 'varchar'],
            'text' => ['tinytext', 'text', 'mediumtext', 'longtext', 'blob'],
            'float' => ['real', 'double'],
            'date' => ['date'],
            'datetime' => ['timestamp'],
        ];
    }

    /**
     * Returns the name of the field in quotes.
     *
     * @param string $fieldName
     *
     * @return string
     */
    public function quoteLiteral($fieldName): string
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
        $query = 'SELECT ' . $this->quoteFieldName('RDB$RELATION_NAME') . '
                  FROM ' . $this->quoteTableName('RDB$RELATIONS', false) . '
                  WHERE ' . $this->quoteFieldName('RDB$VIEW_BLR') . ' IS NULL
                   AND (' . $this->quoteFieldName('RDB$SYSTEM_FLAG') . ' IS NULL
                    OR ' . $this->quoteFieldName('RDB$SYSTEM_FLAG') . ' = 0);';
        return ArrayUtils::flatArray(Database::getInstance()->getDbEngine()->select($query));
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
        return strtoupper(parent::quoteTableName($tableName, $usePrefix));
    }

    /**
     * SQL statement that returns the fields in the table
     *
     * @param string $tableName
     * @param bool   $usePrefix
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
        FROM ' . $this->quoteTableName('RDB$RELATIONS', false) . ' a
        INNER JOIN ' . $this->quoteTableName('RDB$RELATION_FIELDS', false) . ' b ON a.RDB$RELATION_NAME = b.RDB$RELATION_NAME
        INNER JOIN ' . $this->quoteTableName('RDB$FIELDS', false) . ' c ON b.RDB$FIELD_SOURCE = c.RDB$FIELD_NAME
        INNER JOIN ' . $this->quoteTableName('RDB$TYPES', false) . ' d ON c.RDB$FIELD_TYPE = d.RDB$TYPE
        WHERE
            a.RDB$SYSTEM_FLAG = 0 AND
            d.RDB$FIELD_NAME = \'RDB$FIELD_TYPE\' AND
            b.RDB$RELATION_NAME = ' . $this->quoteTableName($tableName, $usePrefix) . '
        ORDER BY b.RDB$FIELD_POSITION;'; // ORDER BY a.RDB$RELATION_NAME, b.RDB$FIELD_ID
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
                trigger_error("Correct the data type '" . $result['type'] . "' in Firebird database", E_ERROR);
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
        return 'SHOW INDEX FROM ' . $this->quoteTableName($tableName);
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
     * Returns the views from the database.
     *
     * @doc http://www.firebirdfaq.org/faq174/
     *
     * @return string
     */
    public function getViewsSql(): string
    {
        return 'SELECT ' . $this->quoteFieldName('RDB$RELATION_NAME') . ' FROM RDB$RELATIONS WHERE RDB$VIEW_BLR IS NOT NULL AND (RDB$SYSTEM_FLAG IS NULL OR RDB$SYSTEM_FLAG = 0);';
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
        // TODO: Not tested
        // https://stackoverflow.com/questions/20699310/how-to-get-foreign-key-referenced-table-in-firebird
        return 'SELECT
                    detail_index_segments.rdb$field_name AS field_name,
                    master_relation_constraints.rdb$relation_name AS reference_table,
                    master_index_segments.rdb$field_name AS fk_field
                FROM
                    rdb$relation_constraints detail_relation_constraints
                    JOIN rdb$index_segments detail_index_segments ON detail_relation_constraints.rdb$index_name = detail_index_segments.rdb$index_name 
                    JOIN rdb$ref_constraints ON detail_relation_constraints.rdb$constraint_name = rdb$ref_constraints.rdb$constraint_name -- Master indeksas
                    JOIN rdb$relation_constraints master_relation_constraints ON rdb$ref_constraints.rdb$const_name_uq = master_relation_constraints.rdb$constraint_name
                    JOIN rdb$index_segments master_index_segments ON master_relation_constraints.rdb$index_name = master_index_segments.rdb$index_name 
                WHERE
                    detail_relation_constraints.rdb$constraint_type = \'FOREIGN KEY\'
                    AND detail_relation_constraints.rdb$relation_name = ' . $this->quoteTableName($tableName, $usePrefix) . '';
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
     * @return string
     */
    public function getSqlTableExists(string $tableName): string
    {
        // TODO: Implement tableExists() method.
        return '';
    }
}
