<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Database;

use Alxarafe\Core\Singletons\Config;

/**
 * The SqlHelper class provides support for creating SQL queries and commands.
 * The class will have to be extended by completing the particularities of each of them.
 */

/**
 * Class SqlHelper
 *
 * Proporciona soporte para la creación de comandos y consultas SQL.
 * Esta clase deberá de extenderse para cada controlador de base de datos específico.
 *
 * @author  Rafael San José Tovar <rafael.sanjose@x-netdigital.com>
 * @version 2023.0101
 *
 * @package Alxarafe\Database
 */
abstract class SqlHelper
{
    /**
     * Retorna el carácter que se usa como separador de nombre de tabla en la consulta SQL.
     *
     * @author  Rafael San José Tovar <rafael.sanjose@x-netdigital.com>
     * @version 2023.0101
     *
     * @return string
     */
    abstract public static function getTableQuote(): string;

    /**
     * Retorna el carácter que se usa como separador de nombre de campo en la consulta SQL.
     *
     * @author  Rafael San José Tovar <rafael.sanjose@x-netdigital.com>
     * @version 2023.0101
     *
     * @return string
     */
    abstract public static function getFieldQuote(): string;

    /**
     * Retorna el nombre de la tabla entre comillas.
     *
     * @author  Rafael San José Tovar <rafael.sanjose@x-netdigital.com>
     * @version 2023.0101
     *
     * @param string $tableName
     *
     * @return string
     */
    public static function quoteTableName(string $tableName): string
    {
        return static::getTableQuote() . $tableName . static::getTableQuote();
    }

    /**
     * Retorna el nombre de un campo entre comillas.
     *
     * @author  Rafael San José Tovar <rafael.sanjose@x-netdigital.com>
     * @version 2023.0101
     *
     * @param string $fieldName
     *
     * @return string
     */
    public static function quoteFieldName(string $fieldName): string
    {
        return static::getFieldQuote() . $fieldName . static::getFieldQuote();
    }

    /**
     * Retorna un array con los distintos tipos de datos del motor
     *
     * @author  Rafael San José Tovar <rafael.sanjose@x-netdigital.com>
     * @version 2023.0101
     *
     * @return array
     */
    abstract public function getDataTypes(): array;

    /**
     * Retorna un array con el nombre de todas las tablas de la base de datos.
     *
     * @author  Rafael San José Tovar <rafael.sanjose@x-netdigital.com>
     * @version 2023.0101
     *
     * @return array
     */
    abstract public static function getTables(): array;

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
     *
     * @return array
     */
    public function getColumns(string $tableName): array
    {
        $query = $this->getColumnsSql($tableName);
        $data = DB::select($query);
        $result = [];
        foreach ($data as $value) {
            $row = $this->normalizeFields($value);
            $result[$row['field']] = $row;
        }
        return $result;
    }

    /**
     * SQL statement that returns the fields in the table
     *
     * @param string $tableName
     *
     * @return string
     */
    abstract public function getColumnsSql(string $tableName): string;

    /**
     * Modifies the structure returned by the query generated with
     * getColumnsSql to the normalized format that returns getColumns
     *
     * @param array $fields
     *
     * @return array
     */
    abstract public function normalizeFields(array $fields): array;

    //abstract public function normalizeConstraints(array $fields): array;

    /**
     * Obtains an array of indexes for a table
     *
     * @param string $tableName
     *
     * @return array
     * @throws \DebugBar\DebugBarException
     */
    public function getIndexes(string $tableName): array
    {
        $query = $this->getIndexesSql($tableName);
        $data = DB::select($query);
        $result = [];
        foreach ($data as $value) {
            $row = $this->normalizeIndexes($value);
            $result[$row['index']] = $row;
        }

        return $result;
    }

    /**
     * Get the SQL sentence for obtains the index list of a table.
     *
     * @param string $tableName
     *
     * @return string
     */
    abstract public function getIndexesSql(string $tableName): string;

    abstract public function normalizeIndexes(array $fields): array;

    /*
      abstract public function getConstraintsSql(string $tableName): string;

      public function getConstraints(string $tableName): array
      {
      $query = $this->getConstraintsSql($tableName);
      $data = DB::select($query);
      $result = [];
      foreach ($data as $value) {
      $row = $this->normalizeConstraints($value);
      $result[$row['constraint']] = $row;
      }

      return $result;
      }
     */
}
