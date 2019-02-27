<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Database\SqlHelpers;

use Alxarafe\Database\SqlHelper;
use Alxarafe\Helpers\Utils;
use Alxarafe\Providers\Database;

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
        parent::__construct();

        $this->tableQuote = '`';
        $this->fieldQuote = '`';
        $this->fieldTypes = [
            'integer' => ['int', 'tinyint'],
            'decimal' => ['decimal'],
            'string' => ['char', 'varchar'],
            'text' => ['text', 'blob'],
            'float' => ['real', 'double'],
            'date' => ['date'],
            'datetime' => ['timestamp'],
        ];
    }

    /**
     * Returns an array with the name of all the tables in the database.
     *
     * @return array
     */
    public function getTables(): array
    {
        $query = 'SHOW TABLES;';
        //$result = Database::getInstance()->getDbEngine()->select($query);
        $result = Database::getInstance()->getDbEngine()->selectCoreCache('tables', $query);
        return Utils::flatArray($result);
    }

    /**
     * SQL statement that returns the fields in the table
     *
     * @param string $tableName
     *
     * @return string
     */
    public function getColumnsSql(string $tableName, bool $prefix): string
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
        return 'SHOW COLUMNS FROM ' . $this->quoteTableName($tableName, $prefix) . ';';
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
        $null = Utils::isTrue($data, 'nullable') ?? null;
//        $autoincrement = Utils::isTrue($data, 'autoincrement') ?? null;
        $zerofill = Utils::isTrue($data, 'zerofill') ?? null;

        $default = $data['default'];
        if (isset($default)) {
            if ($default != 'CURRENT_TIMESTAMP') {
                $default = "'$default'";
            }
        }

        $result = $this->quoteFieldName($fieldName) . ' ' . $this->toNative($data['type'], $data['length'] ?? 0);
        $result .= ($data['unsigned'] === 'yes' ? ' UNSIGNED' : '');
        $result .= ($null ? '' : ' NOT') . ' NULL';
//        $result .= $autoincrement ? ' PRIMARY KEY AUTO_INCREMENT' : '';
        $result .= $zerofill ? ' ZEROFILL' : '';
        $result .= isset($default) ? ' DEFAULT ' . $default : '';

        return $result;
    }

    /**
     * TODO: Undocumented and pending complete.
     *
     * @param array $row
     *
     * @return string
     */
    public function toNative(string $type, int $length = 0): string
    {
        switch ($type) {
            case 'integer':
                $return = $this->toInteger($length);
                break;
            case 'string':
                $return = $this->toString($length);
                break;
            case 'float':
                $return = 'double'; // real use 4 bytes and double 8 bytes
                break;
            case 'datetime':
                $return = 'timestamp';
                break;
            default:
                $return = $type;
                break;
        }

        return $return;
    }

    /**
     * TODO: Undocumented
     *
     * @param int $length
     *
     * @return string
     */
    private function toInteger(int $length = 0): string
    {
        // https://dev.mysql.com/doc/refman/8.0/en/integer-types.html
        // TODO: Integer Types - INTEGER, INT, SMALLINT, TINYINT, MEDIUMINT, BIGINT
        $type = ($length > 2) ? 'int' : 'tinyint';
        return ($length > 0) ? $type . '(' . $length . ')' : $type;
    }

    /**
     * TODO: Undocumented
     *
     * @param int $length
     *
     * @return string
     */
    private function toString(int $length = 0): string
    {
        return $length > 6 ? 'varchar(' . $length . ')' : 'char(' . $length . ')';
    }

    /**
     * Modifies the structure returned by the query generated with getColumnsSql to the normalized format that returns
     * getColumns
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

        /**
         * I thought that this would work
         *
         * $virtualType = array_search($type['type'], $this->fieldTypes);
         */
        $virtualType = $type['type'];
        foreach ($this->fieldTypes as $key => $values) {
            if (in_array($type['type'], $values)) {
                $virtualType = $key;
                break;
            }
        }

        $result['type'] = $virtualType;
        if ($virtualType === false) {
            $result['type'] = $type['type'];
            trigger_error('Correct the data type ' . $type['type'] . ' in MySql database', E_ERROR);
        }
        $result['length'] = $type['length'] ?? null;
        $result['default'] = $row['Default'] ?? null;
        $result['nullable'] = $row['Null'] === 'YES' ? 'yes' : 'no';
        /*
          switch ($row['Key']) {
          case 'PRI':
          $result['key'] = 'primary';
          break;
          case 'UNI':
          $result['key'] = 'unique';
          break;
          case 'MUL':
          $result['key'] = 'index';
          break;
          }
         */
        $result['unsigned'] = $type['unsigned'];
        // $result['zerofill'] = $type['zerofill'];
        if ($row['Extra'] === 'auto_increment') {
            $result['autoincrement'] = 'yes';
        }

        return $result;
    }

    /**
     * Divide the data type of a MySQL field into its various components: type, length, unsigned or zerofill, if
     * applicable.
     *
     * @param string $originalType
     *
     * @return array
     */
    private static function splitType(string $originalType): array
    {
        $explode = explode(' ', strtolower($originalType));

        $pos = strpos($explode[0], '(');
        if ($pos > 0) {
            $size = $pos + 1;
            $type = substr($explode[0], 0, $pos);
            $length = substr($explode[0], $size, strpos($explode[0], ')') - $size);
        } else {
            $type = $explode[0];
            $length = null;
        }

        $pos = array_search('unsigned', $explode);
        $unsigned = $pos ? 'yes' : 'no';

        $pos = array_search('zerofill', $explode);
        $zerofill = $pos ? 'yes' : 'no';

        return ['type' => $type, 'length' => $length, 'unsigned' => $unsigned, 'zerofill' => $zerofill];
    }

    /**
     * Returns an array with the index information, and if there are, also constraints.
     *
     * @param array $fields
     *
     * @return array
     */
    public function normalizeIndexes(array $fields): array
    {
        $result = [];
        $result['index'] = $fields['Key_name'];
        $result['column'] = $fields['Column_name'];
        $result['unique'] = $fields['Non_unique'] == '0' ? 'yes' : 'no';
        $constrait = $this->getConstraintData($fields['Table'], $fields['Key_name']);
        if (count($constrait) > 0) {
            $result['constraint'] = 'yes'; // $constrait[0]['CONSTRAINT_NAME'];
            $result['referencedtable'] = $constrait[0]['REFERENCED_TABLE_NAME'];
            $result['referencedfield'] = $constrait[0]['REFERENCED_COLUMN_NAME'];
        }
        $constrait = $this->getConstraintRules($fields['Table'], $fields['Key_name']);
        if (count($constrait) > 0) {
            $result['matchoption'] = $constrait[0]['MATCH_OPTION'];
            $result['updaterule'] = $constrait[0]['UPDATE_RULE'];
            $result['deleterule'] = $constrait[0]['DELETE_RULE'];
        }
        return $result;
    }

    /**
     * The data about the constraint that is found in the KEY_COLUMN_USAGE table is returned.
     * Attempting to return the consolidated data generates an extremely slow query in some MySQL installations, so 2
     * additional simple queries are made.
     *
     * @param string $tableName
     * @param string $constraintName
     *
     * @return array
     */
    private function getConstraintData(string $tableName, string $constraintName): array
    {
        $sql = 'SELECT
                    ' . Database::getInstance()->getSqlHelper()->quoteFieldName('TABLE_NAME') . ',
                    ' . Database::getInstance()->getSqlHelper()->quoteFieldName('COLUMN_NAME') . ',
                    ' . Database::getInstance()->getSqlHelper()->quoteFieldName('CONSTRAINT_NAME') . ',
                    ' . Database::getInstance()->getSqlHelper()->quoteFieldName('REFERENCED_TABLE_NAME') . ',
                    ' . Database::getInstance()->getSqlHelper()->quoteFieldName('REFERENCED_COLUMN_NAME') . '
                FROM
                    ' . Database::getInstance()->getSqlHelper()->quoteTableName('INFORMATION_SCHEMA', false) . '.' . Database::getInstance()->getSqlHelper()->quoteFieldName('KEY_COLUMN_USAGE') . '
                WHERE
                    ' . Database::getInstance()->getSqlHelper()->quoteFieldName('CONSTRAINT_SCHEMA') . ' = :constraint_schema AND
                    ' . Database::getInstance()->getSqlHelper()->quoteFieldName('TABLE_NAME') . ' = :table_name AND
                    ' . Database::getInstance()->getSqlHelper()->quoteFieldName('constraint_name') . ' = :constraint_name AND
                    ' . Database::getInstance()->getSqlHelper()->quoteFieldName('REFERENCED_COLUMN_NAME') . ' IS NOT NULL;';
        $vars = [
            'constraint_schema' => $this->getTablename(),
            'table_name' => $tableName,
            'constraint_name' => $constraintName,
        ];
        return Database::getInstance()->getDbEngine()->selectCoreCache($tableName . '-constraint-' . $constraintName, $sql, $vars);
    }

    /**
     * Return the DataBaseName or an empty string.
     *
     * TODO: It's not getTablename, it's actually getDbName
     *
     * @return string
     */
    private function getTablename(): string
    {
        return Database::getInstance()->getConnectionData()['dbName'] ?? '';
    }

    /**
     * The rules for updating and deleting data with constraint (table REFERENTIAL_CONSTRAINTS) are returned.
     * Attempting to return the consolidated data generates an extremely slow query in some MySQL installations, so 2
     * additional simple queries are made.
     *
     * @param string $tableName
     * @param string $constraintName
     *
     * @return array
     */
    private function getConstraintRules(string $tableName, string $constraintName): array
    {
        $sql = 'SELECT
                    ' . Database::getInstance()->getSqlHelper()->quoteFieldName('MATCH_OPTION') . ',
                    ' . Database::getInstance()->getSqlHelper()->quoteFieldName('UPDATE_RULE') . ',
                    ' . Database::getInstance()->getSqlHelper()->quoteFieldName('DELETE_RULE') . '
                FROM ' . Database::getInstance()->getSqlHelper()->quoteTableName('INFORMATION_SCHEMA', false) . '.' . Database::getInstance()->getSqlHelper()->quoteFieldName('REFERENTIAL_CONSTRAINTS') . '
                WHERE
                    ' . Database::getInstance()->getSqlHelper()->quoteFieldName('CONSTRAINT_SCHEMA') . ' = :constraint_schema AND
                    ' . Database::getInstance()->getSqlHelper()->quoteFieldName('TABLE_NAME') . ' = :table_name AND
                    ' . Database::getInstance()->getSqlHelper()->quoteFieldName('CONSTRAINT_NAME') . ' = :constraint_name;';
        $vars = [
            'constraint_schema' => $this->getTablename(),
            'table_name' => $tableName,
            'constraint_name' => $constraintName,
        ];
        $result = Database::getInstance()->getDbEngine()->selectCoreCache($tableName . '-constraints-' . $constraintName, $sql, $vars);
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
        return 'SHOW INDEX FROM ' . Database::getInstance()->getSqlHelper()->quoteTableName($tableName, $usePrefix) . ';';
    }

    /**
     * Returns if table exists in the database.
     *
     * @param string $tableName
     *
     * @return string
     */
    public function tableExists(string $tableName): string
    {
        $tableNameWithPrefix = Database::getInstance()->getConnectionData()['dbPrefix'] . $tableName;
        $sql = 'SELECT *  FROM '
            . Database::getInstance()->getSqlHelper()->quoteTableName('INFORMATION_SCHEMA', false) . '.' . Database::getInstance()->getSqlHelper()->quoteFieldName('TABLES')
            . ' WHERE '
            . Database::getInstance()->getSqlHelper()->quoteFieldName('TABLE_SCHEMA') . ' = ' . $this->quoteLiteral($this->getTablename())
            . ' AND ' . Database::getInstance()->getSqlHelper()->quoteFieldName('TABLE_NAME') . ' = ' . $this->quoteLiteral($tableNameWithPrefix) . ';';
        return $sql;
    }
}
