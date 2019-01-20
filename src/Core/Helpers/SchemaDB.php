<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Helpers;

use Exception;

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
        $sql = 'SELECT 1 FROM ' . Config::$sqlHelper->quoteTableName($tableName) . ';';
        return (bool) Config::$dbEngine->exec($sql);
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
    public static function getStructure(string $tableName, bool $usePrefix = true): array
    {
        return Config::$dbEngine->getStructure($tableName, $usePrefix);
    }

    /**
     * Create a table in the database.
     * Build the default fields, indexes and values defined in the model.
     *
     * @param string $tableName
     *
     * @return bool
     */
    public static function createTable(string $tableName): bool
    {
        $tabla = Config::$bbddStructure[$tableName];
        Debug::addMessage('messages', "var_dump: <pre>" . var_export($tabla, true) . "</pre>");

        $sql = self::createFields($tableName, $tabla['fields']);

        foreach ($tabla['indexes'] as $name => $index) {
            $sql .= self::createIndex($tableName, $name, $index);
        }
        $sql .= Schema::setValues($tableName, $tabla['values']);

        echo $sql;

        return Config::$dbEngine->exec($sql);
    }

    protected static function assignFields(array $fieldsList): string
    {
        $fields = [];
        foreach ($fieldsList as $index => $col) {
            $fields[] = Config::$sqlHelper->getSQLField($index, $col);
        }
        return implode(',', $fields);
    }

    /**
     * Build the SQL statement to create the fields in the table.
     * It can also create the primary key if the auto_increment attribute is defined.
     *
     * @param string $tableName
     * @param array  $fieldsList
     *
     * @return string|null
     */
    protected static function createFields(string $tableName, array $fieldsList)
    {
        $sql = 'CREATE TABLE ' . Config::$sqlHelper->quoteTableName($tableName, false) . ' (';
        $sql .= self::assignFields($fieldsList);
        $sql .= ') ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;' . self::CRLF;

        return $sql;
    }

    protected static function createPrimaryIndex(string $tableName, array $indexData, bool $autoincrement)
    {
        // https://www.w3schools.com/sql/sql_primarykey.asp
        // ALTER TABLE Persons ADD CONSTRAINT PK_Person PRIMARY KEY (ID,LastName);
        // 'ADD PRIMARY KEY ('id') AUTO_INCREMENT' is specific of MySQL?
        $sql = 'ALTER TABLE ' . Config::$sqlHelper->quoteTableName($tableName, /* quitar false */ false) . ' ADD PRIMARY KEY (' . Config::$sqlHelper->quoteFieldName($indexData['column']) . ')';
        if ($autoincrement) {
            $sql .= ' AUTO_INCREMENT';
        }
        return $sql . ';' . self::CRLF;
    }

    protected static function createStandardIndex(string $tableName, array $indexData)
    {
        // https://www.w3schools.com/sql/sql_create_index.asp
        // CREATE INDEX idx_pname ON Persons (LastName, FirstName);
        // CREATE UNIQUE INDEX idx_pname ON Persons (LastName, FirstName);
        // $sql = 'CREATE ' . ($unique ? 'UNIQUE ' : '') . 'INDEX ' . $indexData['name'] . ' ON ' . Config::$sqlHelper->quoteTableName($tableName, /* quitar false */ false) . ' (' . Config::$sqlHelper->quoteFieldName($indexData['column']) . ')';
        $sql = 'CREATE INDEX ' . $indexData['index'] . ' ON ' . Config::$sqlHelper->quoteTableName($tableName, /* quitar false */ false) . ' (' . Config::$sqlHelper->quoteFieldName($indexData['column']) . ')';
        return $sql . ';' . self::CRLF;
    }

    protected static function createUniqueIndex(string $tableName, array $indexData)
    {
        // https://www.w3schools.com/sql/sql_unique.asp
        // ALTER TABLE Persons ADD CONSTRAINT UC_Person UNIQUE (ID,LastName);
        $sql = 'ALTER TABLE ' . Config::$sqlHelper->quoteTableName($tableName, /* quitar false */ false) .
            ' ADD CONSTRAINT ' . $indexData['index'] . ' UNIQUE (' . Config::$sqlHelper->quoteFieldName($indexData['column']) . ')';
        return $sql . ';' . self::CRLF;
    }

    protected static function createConstraint(string $tableName, array $indexData)
    {
            // https://www.w3schools.com/sql/sql_foreignkey.asp
        // ALTER TABLE Orders ADD CONSTRAINT FK_PersonOrder FOREIGN KEY (PersonID) REFERENCES Persons(PersonID);
        $sql = 'ALTER TABLE ' . Config::$sqlHelper->quoteTableName($tableName, /* quitar false */ false) .
            ' ADD CONSTRAINT ' . $indexData['index'] . ' UNIQUE (' . Config::$sqlHelper->quoteFieldName($indexData['column']) .
            ') REFERENCES ' . $indexData['referencedtable'] . ' (' . $indexData['referencedfield'] . ')';

        if ($indexData['updaterule'] != '') {
            $sql .= ' ON UPDATE ' . $indexData['updaterule'];
        }

        if ($indexData['deleterule'] != '') {
            $sql .= ' ON DELETE ' . $indexData['deleterule'];
        }

        return $sql . ';' . self::CRLF;
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
     * @return string|null
     */
    protected static function createIndex(string $tableName, string $indexName, array $indexData)
    {
        $fieldData = Config::$bbddStructure[$tableName]['fields'][$indexData['column']];
        if ($indexName == 'PRIMARY') {
            $autoincrement = isset($fieldData['autoincrement']) && ($fieldData['autoincrement'] == 'yes');
            return self::createPrimaryIndex($tableName, $indexData, $autoincrement);
        }

        $unique = isset($indexData['unique']) && ($indexData['unique'] == 'yes');
        //$nullable = isset($indexData['nullable']) && ($indexData['nullable'] == 'yes');
        $constraint = $indexData['constraint'] ?? false;

        if ($constraint) {
            return self::createConstraint($tableName, $indexData);
        }

        return $unique ?
            self::createUniqueIndex($tableName, $indexData) :
            self::createStandardIndex($tableName, $indexData);
    }
}
