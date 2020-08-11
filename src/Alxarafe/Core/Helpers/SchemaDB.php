<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Helpers;

use Alxarafe\Core\Helpers\Utils\ArrayUtils;
use Alxarafe\Core\Models\TableModel;
use Alxarafe\Core\Providers\Database;
use Alxarafe\Core\Providers\FlashMessages;

/**
 * The SchemaDB class contains static methods that allow you to manipulate the database. It is used to create and
 * modify tables and indexes in the database.
 */
class SchemaDB
{
    /**
     * Return the tables on the database.
     *
     * @return array
     */
    public static function getTables(): array
    {
        $queries = Database::getInstance()->getSqlHelper()->getTables();
        $queryResult = [];
        foreach ($queries as $query) {
            $queryResult[] = Database::getInstance()->getDbEngine()->selectCoreCache('tables', $query);
        }
        return ArrayUtils::flatArray($queryResult);
    }

    /**
     * Create or update the structure of the table.
     * It does not destroy fields of the structure, it only creates, adds or modifies the existing ones.
     * NOTE: It could happen that when modifying the structure of a field, information could be lost.
     *
     * @param string $tableName
     *
     * @return bool
     */
    public static function checkTableStructure(string $tableName, $tabla): bool
    {
        Database::getInstance()->getDbEngine()->clearCoreCache($tableName . '-exists');

        // $tabla = Database::getInstance()->getDbEngine()->getDbTableStructure($tableName);
        if (isset($tabla['indexes'])) {
            foreach ($tabla['indexes'] as $key => $index) {
                $autoincrement = ($tabla['fields'][$index['column']]['autoincrement'] ?? 'no') === 'yes';
                if ($autoincrement) {
                    $tabla['indexes'][$key]['autoincrement'] = 'yes';
                    $tabla['indexes'][$key]['length'] = $tabla['fields'][$index['column']]['length'];
                }
            }
        }

        $tableExists = self::tableExists($tableName);
        if ($tableExists) {
            $sql = [];
            $sql = ArrayUtils::addToArray($sql, self::updateFields($tableName, $tabla['fields']));
            if (isset($tabla['indexes'])) {
                $sql = ArrayUtils::addToArray($sql, self::updateIndexes($tableName, $tabla['indexes']));
            }
        } else {
            $sql = self::createFields($tableName, $tabla['fields']);
            if (!Database::getInstance()->getDbEngine()->batchExec($sql)) {
                $data = [
                    'error' => "Maybe the file 'schema" . DIRECTORY_SEPARATOR . $tableName . ".yaml' is missing.",
                    'tableName' => $tableName,
                    'sql' => $sql,
                    'table fields' => $tabla,
                ];
                FlashMessages::getInstance()::setError('Error executing: <pre>' . var_export($data, true) . '</pre>');
                return false;
            }

            $sql = [];
            foreach ($tabla['indexes'] as $name => $index) {
                $sql = ArrayUtils::addToArray($sql, self::createIndex($tableName, $name, $index));
            }

            $values = $tabla['values'] ?? [];
            $values = ArrayUtils::addToArray($values, Schema::getFromYamlFile($tableName, 'values'));
            if (count($values) > 0) {
                $sql = ArrayUtils::addToArray($sql, Schema::setValues($tableName, $values));
            }
            $sql = ArrayUtils::addToArray($sql, self::createTableView($tableName, $tabla));
        }
        return Database::getInstance()->getDbEngine()->batchExec($sql);
    }

    /**
     * Return true if $tableName exists in database
     *
     * @param string $tableName
     *
     * @return bool
     */
    public static function tableExists($tableName): bool
    {
        $sql = Database::getInstance()->getSqlHelper()->getSqlTableExists($tableName);
        return !empty(Database::getInstance()->getDbEngine()->selectCoreCache($tableName . '-exists', $sql));
    }

    /**
     * Update fields for tablename.
     *
     * @param string $tableName
     * @param array  $fieldsList
     *
     * @return array
     */
    protected static function updateFields(string $tableName, array $fieldsList): array
    {
        $fields = self::modifyFields($tableName, $fieldsList);
        if ($fields === '') {
            return [];
        }
        return ['ALTER TABLE ' . self::quoteTableName($tableName, true) . $fields . ';'];
    }

    /**
     * Modify (add or change) fields for tablename.
     *
     * @param string $tableName
     * @param array  $fieldsList
     *
     * @return string
     */
    private static function modifyFields(string $tableName, array $fieldsList): string
    {
        $tableFields = Database::getInstance()->getSqlHelper()->getColumns($tableName);
        $newFields = [];
        $modifiedFields = [];
        foreach ($fieldsList as $key => $fields) {
            unset($fields['key'], $tableFields[$key]['key']);
            if (!isset($tableFields[$key])) {
                $newFields[$key] = $fields;
            } elseif (count(array_diff($fields, $tableFields[$key])) > 0) {
                $modifiedFields[$key] = $fields;
            }
        }
        $sql1 = self::assignFields($modifiedFields, 'MODIFY COLUMN');
        $sql2 = self::assignFields($newFields, 'ADD COLUMN');

        return ($sql1 === '') ? $sql2 : $sql1 . ($sql2 === '' ? '' : ',' . $sql2);
    }

    /**
     * Convert an array of fields into a string to be added to an SQL command, CREATE TABLE or ALTER TABLE.
     * You can add a prefix field operation (usually ADD or MODIFY) that will be added at begin of each field.
     *
     * @param array  $fieldsList
     * @param string $fieldOperation (usually ADD, MODIFY or empty string)
     *
     * @return string
     */
    protected static function assignFields(array $fieldsList, string $fieldOperation = ''): string
    {
        $fields = [];
        foreach ($fieldsList as $index => $col) {
            $field = Database::getInstance()->getSqlHelper()->getSQLField($index, $col);
            if ($field !== '') {
                $fields[] = ' ' . trim($fieldOperation . ' ' . $field);
            }
        }
        return implode(', ', $fields);
    }

    /**
     * Returns the name of the table in quotes.
     *
     * @param string $tableName
     * @param bool   $usePrefix
     *
     * @return string
     */
    private static function quoteTableName($tableName, bool $usePrefix = true): string
    {
        return Database::getInstance()->getSqlHelper()->quoteTableName($tableName, $usePrefix);
    }

    /**
     * Update indexes for tablename.
     *
     * @param string $tableName
     * @param array  $indexesList
     *
     * @return array
     */
    protected static function updateIndexes(string $tableName, array $indexesList): array
    {
        $sql = [];

        $tableIndexes = Database::getInstance()->getSqlHelper()->getIndexes($tableName);
        $quotedTableName = self::quoteTableName($tableName, true);

        // Erase the deleted or modified indexes
        foreach ($tableIndexes as $key => $value) {
            if ($key === 'PRIMARY') {
                // If deleted of YAML, delete it...
                if (!isset($indexesList[$key])) {
                    $sql = ArrayUtils::addToArray($sql, ["ALTER TABLE {$quotedTableName} DROP PRIMARY KEY;"]);
                    continue;
                }
                if ($value != $indexesList[$key]) {
                    $autoincrement = isset($indexesList[$key]['autoincrement']) && $indexesList[$key]['autoincrement'] === 'yes';
                    $sql = ArrayUtils::addToArray($sql, self::createPrimaryIndex($tableName, $indexesList[$key], $autoincrement, true));
                }
                continue;
            }

            if (!isset($indexesList[$key])) {
                if (isset($value['constraint']) && $value['constraint'] === 'yes') {
                    $sql = ArrayUtils::addToArray($sql, ["ALTER TABLE {$quotedTableName} DROP FOREIGN KEY {$key};"]);
                }
                $sql = ArrayUtils::addToArray($sql, ["ALTER TABLE {$quotedTableName} DROP INDEX {$key};"]);
            }
        }

        // Create the missing indexes
        foreach ($indexesList as $key => $value) {
            if ($key === 'PRIMARY') {
                if (isset($tableIndexes[$key])) {
                    continue;
                }
                $autoincrement = isset($value['autoincrement']) && $value['autoincrement'] === 'yes';
                $sql = ArrayUtils::addToArray($sql, self::createPrimaryIndex($tableName, $value, $autoincrement, false));
                continue;
            }
            $value['index'] = $key;
            $exists = isset($tableIndexes[$key]);

            if (isset($value['constraint']) && $value['constraint'] === 'yes') {
                $sql = ArrayUtils::addToArray($sql, ["ALTER TABLE {$quotedTableName} DROP CONSTRAINT {$key};"]);
                $sql = ArrayUtils::addToArray($sql, self::createConstraint($tableName, $value, $exists));
            } else {
                if (isset($value['unique']) && $value['unique'] === 'yes') {
                    $sql = ArrayUtils::addToArray($sql, self::createUniqueIndex($tableName, $value, $exists));
                } else {
                    $sql = ArrayUtils::addToArray($sql, self::createStandardIndex($tableName, $value, $exists));
                }
            }
        }

        return $sql;
    }

    /**
     * Creates index for primary key of tablename.
     *
     * @param string $tableName
     * @param array  $indexData
     * @param bool   $autoincrement
     * @param bool   $exists
     *
     * @return array
     */
    protected static function createPrimaryIndex(string $tableName, array $indexData, bool $autoincrement, bool $exists = false): array
    {
        // https://www.w3schools.com/sql/sql_primarykey.asp
        // ALTER TABLE Persons ADD CONSTRAINT PK_Person PRIMARY KEY (ID,LastName);
        // 'ADD PRIMARY KEY ('id') AUTO_INCREMENT' is specific of MySQL?
        // ALTER TABLE t2 ADD c INT UNSIGNED NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY (c);
        //
        // TODO: Check dependencies of MySQL
        $quotedTableName = self::quoteTableName($tableName, true);
        $columnField = self::quoteFieldName($indexData['column']);
        $sql = [];
        if ($exists) {
            $sql[] = "ALTER TABLE {$quotedTableName} DROP PRIMARY KEY;";
        }
        $sql[] = "ALTER TABLE {$quotedTableName} ADD PRIMARY KEY ({$columnField});";
        if ($autoincrement) {
            $length = $indexData['length'];
            $sql[] = "ALTER TABLE {$quotedTableName} MODIFY {$columnField} INT({$length}) UNSIGNED AUTO_INCREMENT";
        }
        return $sql;
    }

    /**
     * Returns the name of the field in quotes.
     *
     * @param string $fieldName
     *
     * @return string
     */
    private static function quoteFieldName($fieldName): string
    {
        return Database::getInstance()->getSqlHelper()->quoteFieldName($fieldName);
    }

    /**
     * Creates a constraint for tablename.
     *
     * @param string $tableName
     * @param array  $indexData
     * @param bool   $exists
     *
     * @return array
     */
    protected static function createConstraint(string $tableName, array $indexData, bool $exists = false): array
    {
        // https://www.w3schools.com/sql/sql_foreignkey.asp
        // ALTER TABLE Orders ADD CONSTRAINT FK_PersonOrder FOREIGN KEY (PersonID) REFERENCES Persons(PersonID);

        $referencedTableWithoutPrefix = $indexData['referencedtable'];
        $referencedTable = Database::getInstance()->getConnectionData()['dbPrefix'] . $referencedTableWithoutPrefix;

        $sql = [];
        $quotedTableName = self::quoteTableName($tableName, true);
        $indexName = self::quoteFieldName($indexData['index']);
        $columnName = self::quoteFieldName($indexData['column']);
        $referencedTableName = self::quoteFieldName($referencedTable);
        $refencedFieldName = self::quoteFieldName($indexData['referencedfield']);
        if ($exists && ($indexData['deleterule'] === '' || $indexData['updaterule'] === '')) {
            $sql[] = "ALTER TABLE {$quotedTableName} DROP FOREIGN KEY {$indexName};";
        }

        // Delete (if exists) and create the index related to the constraint
        $sql = ArrayUtils::addToArray($sql, self::createStandardIndex($tableName, $indexData, $exists));

        $query = "ALTER TABLE {$quotedTableName} ADD CONSTRAINT {$indexName} FOREIGN KEY ({$columnName}) REFERENCES {$referencedTableName} ({$refencedFieldName})";

        if ($indexData['deleterule'] !== '') {
            $query .= ' ON DELETE ' . $indexData['deleterule'];
        }

        if ($indexData['updaterule'] !== '') {
            $query .= ' ON UPDATE ' . $indexData['updaterule'] . ';';
        }

        $sql[] = $query;

        return $sql;
    }

    /**
     * Creates a standard index for tablename.
     *
     * @param string $tableName
     * @param array  $indexData
     * @param bool   $exists
     *
     * @return array
     */
    protected static function createStandardIndex(string $tableName, array $indexData, bool $exists = false): array
    {
        // https://www.w3schools.com/sql/sql_create_index.asp
        // CREATE INDEX idx_pname ON Persons (LastName, FirstName);
        // CREATE UNIQUE INDEX idx_pname ON Persons (LastName, FirstName);
        $sql = [];
        $quotedTableName = self::quoteTableName($tableName, true);
        $indexName = self::quoteFieldName($indexData['index']);
        $indexColumn = self::quoteFieldName($indexData['column']);
        if ($exists) {
            $sql[] = "ALTER TABLE {$quotedTableName} DROP INDEX {$indexName};";
        }
        $sql[] = "CREATE INDEX {$indexName} ON {$quotedTableName} ({$indexColumn});";
        return $sql;
    }

    /**
     * Creates a unique index for the tablename.
     *
     * @param string $tableName
     * @param array  $indexData
     * @param bool   $exists
     *
     * @return array
     */
    protected static function createUniqueIndex(string $tableName, array $indexData, bool $exists = false): array
    {
        // https://www.w3schools.com/sql/sql_unique.asp
        // ALTER TABLE Persons ADD CONSTRAINT UC_Person UNIQUE (ID,LastName);
        $columnsArray = explode(',', $indexData['column']);
        foreach ($columnsArray as $key => $column) {
            $columnsArray[$key] = self::quoteFieldName($column);
        }
        $columns = implode(',', $columnsArray);

        $sql = [];
        $quotedTableName = self::quoteTableName($tableName, true);
        $indexName = self::quoteFieldName($indexData['index']);
        if ($exists) {
            $sql[] = "ALTER TABLE {$quotedTableName} DROP INDEX {$indexName};";
        }
        $sql[] = "ALTER TABLE {$quotedTableName} ADD CONSTRAINT {$indexName} UNIQUE ({$columns})";
        return $sql;
    }

    /**
     * Build the SQL statement to create the fields in the table.
     * It can also create the primary key if the auto_increment attribute is defined.
     *
     * @param string $tableName
     * @param array  $fieldsList
     *
     * @return array
     */
    protected static function createFields(string $tableName, array $fieldsList): array
    {
        // If the table does not exists
        $sql = 'CREATE TABLE ' . self::quoteTableName($tableName, true) . ' ('
            . self::assignFields($fieldsList)
            . ') ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;';

        return [$sql];
    }

    /**
     * Create the SQL statements for the construction of one index.
     * In the case of the primary index, it is not necessary if it is auto_increment.
     *
     * TODO:
     *
     * Moreover, it should not be defined if it is auto_increment because it would
     * generate an error when it already exists.
     *
     * @param string $tableName
     * @param string $indexName
     * @param array  $indexData
     *
     * @return array
     */
    protected static function createIndex(string $tableName, string $indexName, array $indexData): array
    {
        $tableIndexes = Database::getInstance()->getSqlHelper()->getIndexes($tableName);
        $tableIndex = $tableIndexes[$indexName] ?? [];
        $indexDiff = array_diff($indexData, $tableIndex);
        $existsIndex = isset($tableIndexes[$indexName]);
        $changedIndex = (count($indexDiff) > 0);
        if (!$changedIndex) {
            return [];
        }

        $indexData['index'] = $indexName;

        if ($indexName === 'PRIMARY') {
            $autoincrement = (($indexData['autoincrement'] ?? 'no') === 'yes');
            return self::createPrimaryIndex($tableName, $indexData, $autoincrement, $existsIndex);
        }

        $unique = isset($indexData['unique']) && ($indexData['unique'] === 'yes');
        //$nullable = isset($indexData['nullable']) && ($indexData['nullable'] == 'yes');
        $constraint = $indexData['constraint'] ?? false;

        if ($constraint) {
            return self::createConstraint($tableName, $indexData, $existsIndex);
        }

        return $unique ?
            self::createUniqueIndex($tableName, $indexData, $existsIndex) :
            self::createStandardIndex($tableName, $indexData, $existsIndex);
    }

    /**
     * Create a tableView
     *
     * @param string $tableName
     *
     * @return array
     */
    protected static function createTableView(string $tableName, array $table): array
    {
        return [];

        $primaryColumn = [];
        $nameColumn = [];
        // $tabla = Database::getInstance()->getDbEngine()->getDbTableStructure($tableName);
        $fields = $table['fields'];
        $indexes = $table['indexes'];

        // Ignore indexes that aren't constraints
        foreach ($indexes as $indexName => $indexData) {
            if (isset($indexData['constraint'])) {
                $refTable = (new TableModel())->get($indexData['referencedtable']);
                $newClass = $refTable->namespace;
                if (!empty($newClass)) {
                    $class = new $newClass();
                    $tableNameIndex = $refTable->tablename;
                    $tableIndex[$indexName] = Database::getInstance()->getDbEngine()->getDbTableStructure($tableNameIndex);
                    $primaryColumn[$indexName] = $table['indexes']['PRIMARY']['column'];
                    $nameColumn[$indexName] = $class->getNameField();
                } else {
                    // throw new RuntimeException(
                    //     "Model class for table '" . $indexData['referencedtable'] . "' not loaded. Do you forgot to add 'getDependencies()' to model for '" . $tableName . "' table'."
                    // );
                }
            } else {
                unset($indexes[$indexName]);
            }
        }
        // If no indexes for constraints, we don't need a related view
        if (empty($indexes)) {
            return [];
        }

        $quotedTableName = self::quoteTableName($tableName, true);
        $quotedViewTableName = self::quoteTableName('view_' . $tableName, true);
        $sqlView = "CREATE OR REPLACE VIEW {$quotedViewTableName} AS SELECT ";
        $sep = '';
        foreach ($fields as $fieldName => $fieldData) {
            if (!is_null($fieldName)) {
                $sqlView .= "{$sep}{$quotedTableName}." . self::quoteFieldName($fieldName);
                $sep = ', ';
            }
        }
        foreach ($indexes as $indexName => $indexData) {
            if (!is_null($nameColumn[$indexName])) {
                $sqlView .= $sep . self::quoteTableName($indexData['referencedtable'], true) . '.' . self::quoteFieldName($nameColumn[$indexName])
                    . " AS {$indexData['referencedtable']}_{$nameColumn[$indexName]}";
                $sep = ', ';
            }
        }
        $sqlView .= " FROM {$quotedTableName}";
        foreach ($indexes as $indexName => $indexData) {
            if (!is_null($indexData['column']) && !is_null($primaryColumn[$indexName])) {
                $sqlView .= ' LEFT JOIN ' . self::quoteTableName($indexData['referencedtable'], true)
                    . " ON {$quotedTableName}." . self::quoteFieldName($indexData['column']) . ' = '
                    . self::quoteTableName($indexData['referencedtable'], true) . '.' . self::quoteFieldName($primaryColumn[$indexName]);
            }
        }
        $sqlView .= ';';
        return [$sqlView];
    }
}
