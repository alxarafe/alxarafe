<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Helpers;

/**
 * The SchemaDB class contains static methods that allow you to manipulate the
 * database. It is used to create and modify tables and indexes in the database.
 */
class SchemaDB
{

    /**
     * Symbols for "carry return" and "line feed"
     */
    const CRLF = "\n\t";

    /**
     * Return true if $tableName exists in database
     *
     * @param string $tableName
     *
     * @return bool
     */
    public static function tableExists($tableName): bool
    {
        $sql = 'SELECT 1 FROM ' . Config::$sqlHelper->quoteTableName($tableName, true) . ';';
        return (bool) Config::$dbEngine->exec([$sql]);
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
            $queryResult[] = Config::$dbEngine->select($query);
        }
        return Utils::flatArray($queryResult);
    }
    /**
     * Obtain an array with the table structure with a standardized format.
     *
     * @param string $tableName
     * @param bool   $usePrefix
     *
     * @return array
     */
    /*
     * Delete y really not used!
      public static function getStructure(string $tableName, bool $usePrefix = true): array
      {
      return Config::$dbEngine->getStructure($tableName, $usePrefix);
      }
     * 
     */

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

        Debug::addMessage('messages', "Table creation: var_dump: <pre>" . var_export($tabla, true) . "</pre>");

        $sql = self::createFields($tableName, $tabla['fields']);

        foreach ($tabla['indexes'] as $name => $index) {
            $sql = Utils::addToArray($sql, self::createIndex($tableName, $name, $index));
        }
        $sql = Utils::addToArray($sql, Schema::setValues($tableName, $tabla['values']));

        return Config::$dbEngine->exec($sql);
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
        return implode(',', $fields);
    }

    private static function modifyFields(string $tableName, array $fieldsList): string
    {
        $tableFields = Config::$sqlHelper->getColumns($tableName);
        $newFields = [];
        $modifiedFields = [];
        foreach ($fieldsList as $key => $fields) {
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
        // If the table exists
        if (self::tableExists($tableName)) {
            // $tableFields is structrure in current database
            $fields = self::modifyFields($tableName, $fieldsList);

            $sql = '';
            if ($fields != '') {
                $sql .= 'ALTER TABLE ' . Config::$sqlHelper->quoteTableName($tableName, true) . ' ';
                $sql .= $fields . ';';
                $sql .= self::CRLF;
            }
            return [$sql];
        }

        // If the table does not exists
        $sql = 'CREATE TABLE ' . Config::$sqlHelper->quoteTableName($tableName, true) . ' (';
        $sql .= self::assignFields($fieldsList);
        $sql .= ') ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;' . self::CRLF;

        return [$sql];
    }

    protected static function createPrimaryIndex(string $tableName, array $indexData, bool $autoincrement, bool $exists = false): array
    {
        // https://www.w3schools.com/sql/sql_primarykey.asp
        // ALTER TABLE Persons ADD CONSTRAINT PK_Person PRIMARY KEY (ID,LastName);
        // 'ADD PRIMARY KEY ('id') AUTO_INCREMENT' is specific of MySQL?
        // ALTER TABLE t2 ADD c INT UNSIGNED NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY (c);
        $sql = [];
        if ($exists) {
            $sql[] = 'ALTER TABLE ' . Config::$sqlHelper->quoteTableName($tableName, true) . ' DROP INDEX ' . $indexData['index'] . ';' . self::CRLF;
        }
        $query = 'ALTER TABLE ' . Config::$sqlHelper->quoteTableName($tableName, true) . ' MODIFY ' . Config::$sqlHelper->quoteFieldName($indexData['column']);
        if ($autoincrement) {
            $query .= ' INT UNSIGNED AUTO_INCREMENT, ADD';
        }
        $query .= ' PRIMARY KEY (' . Config::$sqlHelper->quoteFieldName($indexData['column']) . ');' . self::CRLF;
        $sql[] = $query;
        return $sql;
    }

    protected static function createStandardIndex(string $tableName, array $indexData, bool $exists = false): array
    {
        // https://www.w3schools.com/sql/sql_create_index.asp
        // CREATE INDEX idx_pname ON Persons (LastName, FirstName);
        // CREATE UNIQUE INDEX idx_pname ON Persons (LastName, FirstName);
        $sql = [];
        if ($exists) {
            $sql[] = 'ALTER TABLE ' . Config::$sqlHelper->quoteTableName($tableName, true) . ' DROP INDEX ' . $indexData['index'] . ';' . self::CRLF;
        }
        $sql[] = 'CREATE INDEX ' . $indexData['index'] . ' ON ' . Config::$sqlHelper->quoteTableName($tableName, true) . ' (' . Config::$sqlHelper->quoteFieldName($indexData['column']) . ')';
        return $sql;
    }

    protected static function createUniqueIndex(string $tableName, array $indexData, bool $exists = false): array
    {
        // https://www.w3schools.com/sql/sql_unique.asp
        // ALTER TABLE Persons ADD CONSTRAINT UC_Person UNIQUE (ID,LastName);
        $sql = [];
        if ($exists) {
            $sql[] = 'ALTER TABLE ' . Config::$sqlHelper->quoteTableName($tableName, true) . ' DROP ' . $indexData['index'] . ' KEY;' . self::CRLF;
        }
        $sql[] = 'ALTER TABLE ' . Config::$sqlHelper->quoteTableName($tableName, true) .
            ' ADD CONSTRAINT ' . $indexData['index'] . ' UNIQUE (' . Config::$sqlHelper->quoteFieldName($indexData['column']) . ')';
        return $sql;
    }

    protected static function createConstraint(string $tableName, array $indexData, bool $exists = false)
    {
        // https://www.w3schools.com/sql/sql_foreignkey.asp
        // ALTER TABLE Orders ADD CONSTRAINT FK_PersonOrder FOREIGN KEY (PersonID) REFERENCES Persons(PersonID);
        $sql = [];
        if ($exists) {
            $sql[] = 'ALTER TABLE ' . Config::$sqlHelper->quoteTableName($tableName, true) . ' DROP INDEX ' . $indexData['index'] . ';' . self::CRLF;
        }
        $query = 'ALTER TABLE ' . Config::$sqlHelper->quoteTableName($tableName, true) .
            ' ADD CONSTRAINT ' . $indexData['index'] . ' UNIQUE (' . Config::$sqlHelper->quoteFieldName($indexData['column']) .
            ') REFERENCES ' . $indexData['referencedtable'] . ' (' . $indexData['referencedfield'] . ')';

        if ($indexData['updaterule'] != '') {
            $query .= ' ON UPDATE ' . $indexData['updaterule'];
        }

        if ($indexData['deleterule'] != '') {
            $query .= ' ON DELETE ' . $indexData['deleterule'];
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
        $indexDiff = array_diff($tableIndexes[$indexName], $indexData);
        $existsIndex = isset($tableIndexes[$indexName]);
        $changedIndex = (count($indexDiff) > 0);
        if (!$changedIndex) {
            return [];
        }

        $fieldData = Config::$bbddStructure[$tableName]['fields'][$indexData['column']];
        if ($indexName == 'PRIMARY') {
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
}
