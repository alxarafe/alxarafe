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
        return Utils::flatArray(Config::$dbEngine->select($query));
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
     * TODO: Undocumented and pending complete.
     *
     * @param array $row
     *
     * @return string
     */
    public function toNative($type, $length = null): string
    {
        switch ($type) {
            case 'integer':
                if ($length == null) {
                    $return = 'int';
                    break;
                }
                $return = (intval($length) > 2) ? 'int(' . $length . ')' : 'tinyint(' . $length . ')';
                break;
            case 'string':
                $return = (intval($length) > 6) ? 'varchar(' . $length . ')' : 'char(' . $length . ')';
                break;
            case 'float':
                $return = 'double'; // ['real', 'double'],
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
     * TODO: Undocummented.
     *
     * @param string $fieldName
     * @param array  $data
     *
     * @return string
     */
    public function getSQLField(string $fieldName, array $data): string
    {
        $null = $this->isYes($data['nullable']);
        $autoincrement = $this->isYes($data['autoincrement']);
        $zerofill = $this->isYes($data['zerofill']);

        $default = $data['default'];
        if (isset($default)) {
            if ($default != 'CURRENT_TIMESTAMP') {
                $default = "'$default'";
            }
        }

        $result = $this->quoteFieldName($fieldName) . ' ' . $this->toNative($data['type'], $data['length']);
        $result .= ($null ? '' : ' NOT') . ' NULL';
        $result .= $autoincrement ? ' PRIMARY KEY AUTO_INCREMENT' : '';
        $result .= $zerofill ? ' ZEROFILL' : '';
        $result .= isset($default) ? ' DEFAULT ' . $default : '';

        return $result;
    }

    /**
     * Return true if $param is setted and is 'yes', otherwise return false.
     *
     * @param string $param
     *
     * @return bool
     */
    private function isYes($param)
    {
        return (isset($param) && ($param == 'yes'));
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
            Debug::addMessage('Deprecated', 'Correct the data type ' . $type['type'] . ' in MySql database');
        }
        $result['length'] = $type['length'] ?? null;
        $result['default'] = $row['Default'] ?? null;
        $result['nullable'] = $row['Null'] ? 'yes' : 'no';
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
        $result['unsigned'] = $type['unsigned'];
        $result['zerofill'] = $type['zerofill'];
        $result['autoincrement'] = $row['Extra'] == 'auto_increment' ? 'yes' : 'no';

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
        $result['unique'] = $fields['Non_unique'] == '0' ? 1 : 0;
        $result['nullable'] = $fields['Null'] == 'YES' ? 1 : 0;
        $constrait = $this->getConstraintData($fields['Table'], $fields['Key_name']);
        if (count($constrait) > 0) {
            $result['constraint'] = $constrait[0]['CONSTRAINT_NAME'];
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
                    TABLE_NAME,
                    COLUMN_NAME,
                    CONSTRAINT_NAME,
                    REFERENCED_TABLE_NAME,
                    REFERENCED_COLUMN_NAME
                FROM
                    INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                WHERE
                    TABLE_SCHEMA = ' . $this->quoteLiteral($this->getTablename()) . ' AND
                    TABLE_NAME = ' . $this->quoteLiteral($tableName) . ' AND
                    constraint_name = ' . $this->quoteLiteral($constraintName) . ' AND
                    REFERENCED_COLUMN_NAME IS NOT NULL;';
        return Config::$dbEngine->select($sql);
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
                    MATCH_OPTION,
                    UPDATE_RULE,
                    DELETE_RULE
                FROM information_schema.REFERENTIAL_CONSTRAINTS
                WHERE
                    constraint_schema = ' . $this->quoteLiteral($this->getTablename()) . ' AND
                    table_name = ' . $this->quoteLiteral($tableName) . ' AND
                    constraint_name = ' . $this->quoteLiteral($constraintName) . ';';
        return Config::$dbEngine->select($sql);
    }

    /**
     * Return the tablename or an empty string.
     *
     * @return string
     */
    private function getTablename(): string
    {
        return Config::getVar('dbName') ?? '';
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
        return 'SHOW INDEX FROM ' . Config::$sqlHelper->quoteTableName($tableName, $usePrefix) . ';';
    }

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
}
