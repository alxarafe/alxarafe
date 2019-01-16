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
        $this->fieldQuote = '"';
        $this->fieldTypes = [
            'integer' => ['int', 'tinyint'],
            'decimal' => ['decimal'],
            'string' => ['varchar'],
            'float' => ['real', 'double'],
            'date' => ['date'],
            'datetime' => ['datetime', 'timestamp'],
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
        return 'SHOW COLUMNS FROM ' . $this->quoteTableName($tableName, true) . ';';
    }

    public function toNativeForm(array $row): string
    {
        return '';
        /*
        if ($type == 'string') {
            if ($max == 0) {
                $max = constant(DEFAULT_STRING_LENGTH);
            }
            $dbType = "$dbType($max)";
            $ret['pattern'] = '.{' . $min . ',' . $max . '}';
        } else {
            if ($type == 'number') {
                if ($default === true) {
                    $default = '1';
                }
                if ($max == 0) {
                    $_length = constant(DEFAULT_INTEGER_SIZE);
                    $max = pow(10, $_length) - 1;
                } else {
                    $_length = strlen($max);
                }

                if ($min == 0) {
                    $min = $unsigned ? 0 : -$max;
                } else {
                    if ($_length < strlen($min)) {
                        $_length = strlen($min);
                    }
                }

                if (isset($structure['decimals'])) {
                    $decimales = $structure['decimals'];
                    $precision = pow(10, -$decimales);
                    $_length += $decimales;
                    $dbType = "decimal($_length,$decimales)" . ($unsigned ? ' unsigned' : '');
                    $ret['min'] = $min == 0 ? 0 : ($min < 0 ? $min - 1 + $precision : $min + 1 - $precision);
                    $ret['max'] = $max > 0 ? $max + 1 - $precision : $max - 1 + $precision;
                } else {
                    $precision = null;
                    $dbType = "integer($_length)" . ($unsigned ? ' unsigned' : '');
                    $ret['min'] = $min;
                    $ret['max'] = $max;
                }
            }
        }

        $ret['type'] = $type;
        $ret['dbtype'] = $dbType;
        $ret['default'] = $default;
        $ret['null'] = $null;
        $ret['label'] = $label;
        if (isset($precision)) {
            $ret['step'] = $precision;
        }
        if (isset($structure['key'])) {
            $ret['key'] = $structure['key'];
        }
        if (isset($structure['placeholder'])) {
            $ret['placeholder'] = $structure['placeholder'];
        }
        if (isset($structure['extra'])) {
            $ret['extra'] = $structure['extra'];
        }
        if (isset($structure['help'])) {
            $ret['help'] = $structure['help'];
        }
        if (isset($structure['unique']) && $structure['unique']) {
            $ret['unique'] = $structure['unique'];
        }

        if (isset($structure['relations'][$field]['table'])) {
            $ret['relation'] = [
                'table' => $structure['relations'][$field]['table'],
                'id' => isset($structure['relations'][$field]['id']) ? $structure['relations'][$field]['id'] : 'id',
                'name' => isset($structure['relations'][$field]['name']) ? $structure['relations'][$field]['name'] : 'name',
            ];
        }

        return $ret;
        */
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
     * @param array $row
     *
     * @return array
     */
    public function normalizeIndexes(array $row): array
    {
        $result = [];
        $result['index'] = $row['Key_name'];
        $result['column'] = $row['Column_name'];
        $result['unique'] = $row['Non_unique'] == '0' ? 1 : 0;
        $result['nullable'] = $row['Null'] == 'YES' ? 1 : 0;
        $constrait = $this->getConstraintData($row['Table'], $row['Key_name']);
        if (count($constrait) > 0) {
            $result['constraint'] = $constrait[0]['CONSTRAINT_NAME'];
            $result['referencedtable'] = $constrait[0]['REFERENCED_TABLE_NAME'];
            $result['referencedfield'] = $constrait[0]['REFERENCED_COLUMN_NAME'];
        }
        $constrait = $this->getConstraintRules($row['Table'], $row['Key_name']);
        if (count($constrait) > 0) {
            $result['matchoption'] = $constrait[0]['MATCH_OPTION'];
            $result['updaterule'] = $constrait[0]['UPDATE_RULE'];
            $result['deleterule'] = $constrait[0]['DELETE_RULE'];
        }
        return $result;
    }

    /**
     * The data about the constraint that is found in the KEY_COLUMN_USAGE table
     * is returned.
     * Attempting to return the consolidated data generates an extremely slow query
     * in some MySQL installations, so 2 additional simple queries are made.
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
                    TABLE_SCHEMA = ' . $this->quoteFieldName($this->getTablename()) . ' AND
                    TABLE_NAME = ' . $this->quoteFieldName($tableName) . ' AND
                    constraint_name = ' . $this->quoteFieldName($constraintName) . ' AND
                    REFERENCED_COLUMN_NAME IS NOT NULL;';
        return Config::$dbEngine->select($sql);
    }

    /**
     * The rules for updating and deleting data with constraint (table
     * REFERENTIAL_CONSTRAINTS) are returned.
     * Attempting to return the consolidated data generates an extremely slow query
     * in some MySQL installations, so 2 additional simple queries are made.
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
                    constraint_schema = ' . $this->quoteFieldName($this->getTablename()) . ' AND
                    table_name = ' . $this->quoteFieldName($tableName) . ' AND
                    constraint_name = ' . $this->quoteFieldName($constraintName) . ';';
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
     * Obtain an array with the basic information about the indexes of the table,
     * which will be supplemented with the restrictions later.
     *
     * @param string $tableName
     *
     * @return string
     */
    public function getIndexesSql(string $tableName): string
    {
        // https://stackoverflow.com/questions/5213339/how-to-see-indexes-for-a-database-or-table-in-mysql

        return 'SHOW INDEX FROM ' . Config::$sqlHelper->quoteTableName($tableName, true) . ';';
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
        // TODO: Implement getConstraintsSql() method.
        return '';
    }
}
