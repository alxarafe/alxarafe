<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Helpers;

use \Alxarafe\Models\TableModel;

/**
 * The SchemaDB class contains static methods that allow you to manipulate the
 * database. It is used to create and modify tables and indexes in the database.
 */
class SchemaDB
{

    /**
     * Return true if $tableName exists in database
     *
     * @param string $tableName
     *
     * @return bool
     */
    public static function tableExists($tableName): bool
    {
        //$sql = 'SELECT 1 FROM ' . Config::$sqlHelper->quoteTableName($tableName, true) . ' LIMIT 1;';
        $sql = Config::$sqlHelper->tableExists($tableName);
        return !empty(Config::$dbEngine->selectCoreCache($tableName . '-exists', $sql));
    }

    /**
     * Return the tables on the database.
     *
     * @return array
     */
    public static function getTables(): array
    {
        $queries = Config::$sqlHelper->getTables();
        $queryResult = [];
        foreach ($queries as $query) {
            $queryResult[] = Config::$dbEngine->selectCoreCache('tables', $query);
        }
        return Utils::flatArray($queryResult);
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
    public static function checkTableStructure(string $tableName): bool
    {
        $tabla = Config::$bbddStructure[$tableName];

        $tableExists = self::tableExists($tableName);
        if ($tableExists) {
//            Debug::addMessage('messages', "Update table '" . $tableName . "' fields: <pre>" . var_export($tabla, true) . "</pre>");
            $sql = self::updateFields($tableName, $tabla['fields']);
            // TODO: Needs to be added call to updated indexes.
        } else {
//            Debug::addMessage('messages', "Create table '" . $tableName . "' : <pre>" . var_export($tabla, true) . "</pre>");
            Config::$dbEngine->clearCoreCache($tableName . '-exists');
            $sql = self::createFields($tableName, $tabla['fields']);

            if (!Config::$dbEngine->batchExec($sql)) {
                return false;
            }

            $sql = [];
            foreach ($tabla['indexes'] as $name => $index) {
                $sql = Utils::addToArray($sql, self::createIndex($tableName, $name, $index));
            }

            $values = Utils::addToArray($tabla['values'], Schema::getFromYamlFile($tableName, 'values'));
            $sql = Utils::addToArray($sql, Schema::setValues($tableName, $values));
            $sql = Utils::addToArray($sql, self::createTableView($tableName));
        }

        return Config::$dbEngine->batchExec($sql);
    }

    /**
     * Convert an array of fields into a string to be added to an SQL command, CREATE TABLE or ALTER TABLE.
     * You can add a prefix field operation (usually ADD or MODIFY) that will be added at begin of each field.
     *
     * @param array $fieldsList
     * @param string $fieldOperation (usually ADD, MODIFY or empty string)
     * @return string
     */
    protected static function assignFields(array $fieldsList, string $fieldOperation = ''): string
    {
        $fields = [];
        foreach ($fieldsList as $index => $col) {
            $field = Config::$sqlHelper->getSQLField($index, $col);
            if ($field != '') {
                $fields[] = trim($fieldOperation . ' ' . $field);
            }
        }
        return implode(', ', $fields);
    }

    /**
     * TODO: Undocumented
     *
     * @param string $tableName
     * @param array  $fieldsList
     *
     * @return string
     */
    private static function modifyFields(string $tableName, array $fieldsList): string
    {
        $tableFields = Config::$sqlHelper->getColumns($tableName);
        $newFields = [];
        $modifiedFields = [];
        foreach ($fieldsList as $key => $fields) {
            unset($fields['key']);
            unset($tableFields[$key]['key']);
            if (!isset($tableFields[$key])) {
                $newFields[$key] = $fields;
            } else {
                if (count(array_diff($fields, $tableFields[$key])) > 0) {
                    $modifiedFields[$key] = $fields;
                }
            }
        }
        $sql1 = self::assignFields($modifiedFields, 'MODIFY COLUMN');
        $sql2 = self::assignFields($newFields, 'ADD COLUMN');

        return ($sql1 == '') ? $sql2 : $sql1 . ($sql2 == '' ? '' : ',' . $sql2);
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
        $sql = 'CREATE TABLE ' . Config::$sqlHelper->quoteTableName($tableName, true) . ' (';
        $sql .= self::assignFields($fieldsList);
        $sql .= ') ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;';

        return [$sql];
    }

    /**
     * TODO: Undocumented
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
        return ['ALTER TABLE ' . Config::$sqlHelper->quoteTableName($tableName, true) . ' ' . $fields . ';'];
    }

    /**
     * TODO: Undocumented
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
        $sql = [];
        if ($exists) {
            $sql[] = 'ALTER TABLE ' . Config::$sqlHelper->quoteTableName($tableName, true) . ' DROP PRIMARY KEY;';
        }
        $sql[] = 'ALTER TABLE ' . Config::$sqlHelper->quoteTableName($tableName, true) .
            ' ADD PRIMARY KEY (' . Config::$sqlHelper->quoteFieldName($indexData['column']) . ');';
        if ($autoincrement) {
            $length = Config::$bbddStructure[$tableName]['fields'][$indexData['column']]['length'];
            $sql[] = 'ALTER TABLE ' . Config::$sqlHelper->quoteTableName($tableName, true) .
                ' MODIFY ' . Config::$sqlHelper->quoteFieldName($indexData['column']) .
                ' INT(' . $length . ') UNSIGNED AUTO_INCREMENT';
        }
        return $sql;
    }

    /**
     * TODO: Undocumented
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
        if ($exists) {
            $sql[] = 'ALTER TABLE ' . Config::$sqlHelper->quoteTableName($tableName, true) . ' DROP INDEX ' . Config::$sqlHelper->quoteFieldName($indexData['index']) . ';';
        }
        $sql[] = 'CREATE INDEX ' . Config::$sqlHelper->quoteFieldName($indexData['index']) . ' ON ' . Config::$sqlHelper->quoteTableName($tableName, true) . ' (' . Config::$sqlHelper->quoteFieldName($indexData['column']) . ');';
        return $sql;
    }

    /**
     * TODO: Undocumented
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
            $columnsArray[$key] = Config::$sqlHelper->quoteFieldName($column);
        }
        $columns = implode(',', $columnsArray);

        $sql = [];
        if ($exists) {
            $sql[] = 'ALTER TABLE ' . Config::$sqlHelper->quoteTableName($tableName, true) . ' DROP INDEX ' . $indexData['index'] . ';';
        }
        $sql[] = 'ALTER TABLE ' . Config::$sqlHelper->quoteTableName($tableName, true) .
            ' ADD CONSTRAINT ' . Config::$sqlHelper->quoteFieldName($indexData['index']) . ' UNIQUE (' . $columns . ')';
        return $sql;
    }

    /**
     * TODO: Undocumented
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
        $referencedTable = Config::getVar('dbPrefix') . $referencedTableWithoutPrefix;

        $sql = [];
        if ($exists && ($indexData['deleterule'] == '' || $indexData['updaterule'] == '' )) {
            $sql[] = 'ALTER TABLE ' . Config::$sqlHelper->quoteTableName($tableName, true) . ' DROP FOREIGN KEY ' . Config::$sqlHelper->quoteFieldName($indexData['index']) . ';';
        }

        // Delete (if exists) and create the index related to the constraint
        $sql = Utils::addToArray($sql, self::createStandardIndex($tableName, $indexData, $exists));

        $query = 'ALTER TABLE ' . Config::$sqlHelper->quoteTableName($tableName, true) .
            ' ADD CONSTRAINT ' . Config::$sqlHelper->quoteFieldName($indexData['index']) . ' FOREIGN KEY (' . Config::$sqlHelper->quoteFieldName($indexData['column']) .
            ') REFERENCES ' . Config::$sqlHelper->quoteFieldName($referencedTable) . ' (' . Config::$sqlHelper->quoteFieldName($indexData['referencedfield']) . ')';

        if ($indexData['deleterule'] != '') {
            $query .= ' ON DELETE ' . $indexData['deleterule'];
        }

        if ($indexData['updaterule'] != '') {
            $query .= ' ON UPDATE ' . $indexData['updaterule'] . ';';
        }

        $sql[] = $query;

        return $sql;
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
     * @param string $indexname
     * @param array  $indexData
     *
     * @return array
     */
    protected static function createIndex(string $tableName, string $indexName, array $indexData): array
    {
        $tableIndexes = Config::$sqlHelper->getIndexes($tableName);
        $tableIndex = $tableIndexes[$indexName] ?? [];
        $indexDiff = array_diff($indexData, $tableIndex);
        $existsIndex = isset($tableIndexes[$indexName]);
        $changedIndex = (count($indexDiff) > 0);
        if (!$changedIndex) {
            return [];
        }

        $indexData['index'] = $indexName;

        if ($indexName == 'PRIMARY') {
            $fieldData = Config::$bbddStructure[$tableName]['fields'][$indexData['column']];
            $autoincrement = isset($fieldData['autoincrement']) && ($fieldData['autoincrement'] == 'yes');
            return self::createPrimaryIndex($tableName, $indexData, $autoincrement, $existsIndex);
        }

        $unique = isset($indexData['unique']) && ($indexData['unique'] == 'yes');
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
    protected static function createTableView(string $tableName): array
    {
        $tabla = Config::$bbddStructure[$tableName];
        $fields = $tabla['fields'];
        $indexes = $tabla['indexes'];

        // Ignore indexes that aren't constraints
        foreach ($indexes as $indexName => $indexData) {
            if (isset($indexData['constraint'])) {
                $table = (new TableModel())->get($indexData['referencedtable']);
                $class = $table->namespace;
                $class = new $class();
                $tableNameIndex = $table->tablename;
                $tableIndex[$indexName] = Config::$bbddStructure[$tableNameIndex];
                $primaryColumn[$indexName] = $tabla['indexes']['PRIMARY']['column'];
                $nameColumn[$indexName] = $class->getNameField();
            } else {
                unset($indexes[$indexName]);
            }
        }
        // If no indexes for constraints, we don't need a related view
        if (empty($indexes)) {
            return [];
        }

        $sqlView = 'CREATE OR REPLACE VIEW ' . Config::$sqlHelper->quoteTableName('view_' . $tableName, true) . ' AS';
        $sqlView .= ' SELECT ';
        $sep = '';
        foreach ($fields as $fieldName => $fieldData) {
            $sqlView .= $sep . Config::$sqlHelper->quoteTableName($tableName, true) . '.' . Config::$sqlHelper->quoteFieldName($fieldName);
            $sep = ', ';
        }
        foreach ($indexes as $indexName => $indexData) {
            $sqlView .= $sep . Config::$sqlHelper->quoteTableName($indexData['referencedtable'], true) . '.' . Config::$sqlHelper->quoteFieldName($nameColumn[$indexName]) . ' AS ' . $indexData['referencedtable'] . '_' . $nameColumn[$indexName];
            $sep = ', ';
        }
        $sqlView .= ' FROM ' . Config::$sqlHelper->quoteTableName($tableName, true);
        foreach ($indexes as $indexName => $indexData) {
            $sqlView .= ' LEFT JOIN ' . Config::$sqlHelper->quoteTableName($indexData['referencedtable'], true) . ' ON ' . Config::$sqlHelper->quoteTableName($tableName, true) . '.' . Config::$sqlHelper->quoteFieldName($indexData['column']) . ' = ' . Config::$sqlHelper->quoteTableName($indexData['referencedtable'], true) . '.' . Config::$sqlHelper->quoteFieldName($primaryColumn[$indexName]);
        }
        $sqlView .= ';';
        return [$sqlView];
    }
}
