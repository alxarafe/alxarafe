<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Database;

use Alxarafe\Core\Helpers\Utils\ClassUtils;
use Alxarafe\Core\Providers\Database;
use Alxarafe\Core\Providers\DebugTool;

/**
 * Engine provides generic support for databases.
 * The class will have to be extended by completing the particularities of each of them.
 */
abstract class SqlHelper
{
    /**
     * Character used as quotes to enclose the name of the table
     *
     * @var string
     */
    protected $tableQuote;

    /**
     * Character used as quotes to enclose the name of a field
     *
     * @var string
     */
    protected $fieldQuote;

    /**
     * Character used as quotes to enclose the literal fields
     *
     * @var string
     */
    protected $literalQuote;

    /**
     * It contains an associative array in which each index is a type of virtual field, and its content is each of the
     * types it represents.
     *
     * @var array
     */
    protected $fieldTypes;

    /**
     * SqlHelper constructor.
     */
    public function __construct()
    {
        $shortName = ClassUtils::getShortName($this, static::class);
        $debugTool = DebugTool::getInstance();
        $debugTool->startTimer($shortName, $shortName . ' SqlHelper Constructor');

        $this->tableQuote = '';
        $this->fieldQuote = '';
        $this->literalQuote = '"';
        $this->fieldTypes = [];

        $debugTool->stopTimer($shortName);
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
        return $this->tableQuote .
            ($usePrefix ? Database::getInstance()->getConnectionData()['dbPrefix'] : '') .
            $tableName . $this->tableQuote;
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
        return Database::getInstance()->getSqlHelper()->fieldQuote . $fieldName . Database::getInstance()->getSqlHelper()->fieldQuote;
    }

    /**
     * Returns the name of the field in quotes.
     *
     * @param string|null $fieldName
     *
     * @return string
     */
    public function quoteLiteral($fieldName): string
    {
        return $fieldName === null ? 'NULL' : Database::getInstance()->getSqlHelper()->literalQuote . $fieldName . Database::getInstance()->getSqlHelper()->literalQuote;
    }

    /**
     * Returns an array with the name of all the tables in the database.
     *
     * @return array
     */
    abstract public function getTables(): array;

    /**
     * Returns if table exists in the database.
     *
     * @param string $tableName
     *
     * @return string
     */
    abstract public function getSqlTableExists(string $tableName): string;

    /**
     * TODO: Undocummented.
     *
     * @param string $fieldName
     * @param array  $data
     *
     * @return string
     */
    abstract public function getSQLField(string $fieldName, array $data): string;

    /**
     * Returns an array with all the columns of a table
     *
     * TODO: Review the types. The variants will depend on type + length.
     *
     * 'name_of_the_field' => {
     *  (Required type and length or bytes)
     *      'type' => (string/integer/float/decimal/boolean/date/datetime/text/blob)
     *      'length' => It is the number of characters that the field needs (optional if bytes exists)
     *      'bytes' => Number of bytes occupied by the data (optional if length exists)
     *  (Optional)
     *      'default' => Default value
     *      'nullable' => True if it can be null
     *      'primary' => True if it is the primary key
     *      'autoincrement' => True if it is an autoincremental number
     *      'zerofilled' => True if it completes zeros on the left
     * }
     *
     * @param string $tableName
     * @param bool   $usePrefix
     *
     * @return array
     */
    public function getColumns(string $tableName, bool $usePrefix = true): array
    {
        $query = $this->getColumnsSql($tableName, $usePrefix);
        $data = Database::getInstance()->getDbEngine()->selectCoreCache($tableName . '-columns', $query);
        $result = [];
        foreach ($data as $value) {
            $row = $this->normalizeFields($value);
            $field = $row['field'];
            unset($row['field']);
            $result[$field] = $row;
        }
        return $result;
    }

    /**
     * SQL statement that returns the fields in the table
     *
     * @param string $tableName
     * @param bool   $usePrefix
     *
     * @return string
     */
    abstract public function getColumnsSql(string $tableName, bool $usePrefix): string;

    /**
     * Modifies the structure returned by the query generated with getColumnsSql to the normalized format that returns
     * getColumns
     *
     * @param array $fields
     *
     * @return array
     */
    abstract public function normalizeFields(array $fields): array;

    /**
     * Obtains information about the indices of the table in a normalized array
     * and independent of the database engine
     *
     * @param string $tableName
     * @param bool   $usePrefix
     *
     * @return array
     */
    public function getIndexes(string $tableName, bool $usePrefix = true): array
    {
        $query = $this->getIndexesSql($tableName, $usePrefix);
        $data = Database::getInstance()->getDbEngine()->selectCoreCache($tableName . '-indexes', $query);

        $result = [];

        foreach ($data as $value) {
            $row = $this->normalizeIndexes($value);
            // If there exists is a composite index
            if (isset($result[$row['index']])) {
                $result[$row['index']]['column'] .= ',' . $row['column'];
            } else {
                $result[$row['index']] = $row;
            }
        }
        // Field index it's not necessary!
        foreach ($result as $key => $value) {
            unset($result[$key]['index']);
        }
        return $result;
    }

    /**
     * Obtain an array with the basic information about the indexes of the table, which will be supplemented with the
     * restrictions later.
     *
     * @param string $tableName
     * @param bool   $usePrefix
     *
     * @return string
     */
    abstract public function getIndexesSql(string $tableName, bool $usePrefix = true): string;

    /**
     * Returns an array with the index information, and if there are, also constraints.
     *
     * @param array $fields
     *
     * @return array
     */
    abstract public function normalizeIndexes(array $fields): array;
}
