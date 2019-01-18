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
        var_dump($tabla);

        $sql = self::createFields($tableName, $tabla['fields']);

        /*
          foreach ($tabla['keys'] as $name => $index) {
          $sql .= self::createIndex($tableName, $name, $index);
          }
          $sql .= Schema::setValues($tableName, $tabla['values']);
         */
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
    protected static function createIndex(string $tableName, string $indexname, array $indexData)
    {
        $fields = '';
        $sql = 'ALTER TABLE ' . Config::$sqlHelper->quoteTableName($tableName) . ' ADD CONSTRAINT ' . $indexname;

        $command = '';
        // https://www.w3schools.com/sql/sql_primarykey.asp
        // ALTER TABLE Persons ADD CONSTRAINT PK_Person PRIMARY KEY (ID,LastName);
        if (isset($indexData['PRIMARY'])) {
            $command = 'PRIMARY KEY ';
            $fields = $indexData['PRIMARY'];
        }

        // https://www.w3schools.com/sql/sql_create_index.asp
        // CREATE INDEX idx_pname ON Persons (LastName, FirstName);
        if (isset($indexData['INDEX'])) {
            $command = 'INDEX ';
            $fields = $indexData['INDEX'];
        }

        // https://www.w3schools.com/sql/sql_unique.asp
        // ALTER TABLE Persons ADD CONSTRAINT UC_Person UNIQUE (ID,LastName);
        if (isset($indexData['UNIQUE'])) {
            $command = 'UNIQUE INDEX ';
            $fields = $indexData['UNIQUE'];
        }

        if ($command == '') {
            // https://www.w3schools.com/sql/sql_foreignkey.asp
            // ALTER TABLE Orders ADD CONSTRAINT FK_PersonOrder FOREIGN KEY (PersonID) REFERENCES Persons(PersonID);
            if (isset($indexData['FOREIGN'])) {
                $command = 'FOREIGN KEY ';
                $foreignField = $indexData['FOREIGN'];
                if (isset($indexData['REFERENCES'])) {
                    $references = $indexData['REFERENCES'];
                    if (!is_array($references)) {
                        $msg = 'Esperaba un array en REFERENCES: ' . $tableName . '/' . $indexname;
                        $e = new Exception($msg);
                        Debug::addException($e);
                        return null;
                    }
                    if (count($references) != 1) {
                        $msg = 'Esperaba un array de 1 elemento en REFERENCES: ' . $tableName . '/' . $indexname;
                        $e = new Exception($msg);
                        Debug::addException($e);
                        return null;
                    }
                    $refTable = key($references);
                    $fields = '(' . implode(',', $references) . ')';
                } else {
                    $msg = 'FOREIGN necesita REFERENCES en ' . $tableName . '/' . $indexname;
                    $e = new Exception($msg);
                    Debug::addException($e);
                    return null;
                }

                $sql .= $command . ' ' . $foreignField . ' REFERENCES ' . $refTable . $fields;

                if (isset($indexData['ON']) && is_array($indexData['ON'])) {
                    foreach ($indexData['ON'] as $key => $value) {
                        $sql .= ' ON ' . $key . ' ' . $value . ', ';
                    }
                    $sql = substr($sql, 0, -2); // Quitamos el ', ' de detrás
                }
            }
        } else {
            if (is_array($fields)) {
                $fields = '(' . implode(',', $fields) . ')';
            } else {
                $fields = "($fields)";
            }

            if ($command == 'INDEX ') {
                $sql = "CREATE INDEX {$indexname} ON {$tableName}" . $fields;
            } else {
                $sql .= $command . ' ' . $fields;
            }
        }

        return $sql . ';' . self::CRLF;
    }
}
