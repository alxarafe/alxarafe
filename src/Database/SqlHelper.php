<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Database;

/**
 * Class SqlHelper
 *
 * Proporciona soporte para la creación de comandos y consultas SQL.
 * Esta clase deberá de extenderse para cada controlador de base de datos específico.
 * Se usa desde la clase estática DB.
 *
 * @author  Rafael San José Tovar <info@rsanjoseo.com>
 * @version 2023.0101
 *
 * @package Alxarafe\Database
 */
abstract class SqlHelper
{
    /**
     * Retorna el nombre de la tabla entre comillas.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
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
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
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
     * Retorna las comillas que encierran al nombre de la tabla en una consulta SQL.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0101
     *
     * @return string
     */
    abstract public static function getTableQuote(): string;

    /**
     * Retorna las comillas que encierran al nombre de un campo en una consulta SQL
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0101
     *
     * @return string
     */
    abstract public static function getFieldQuote(): string;

    /**
     * Permite saber si una tabla existe.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0106
     *
     * @param string $tableName
     *
     * @return bool
     */
    abstract public static function tableExists(string $tableName): bool;

    /**
     * Retorna un array con la asociación de tipos del motor SQL para cada tipo definido
     * en el Schema.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0101
     *
     * @return array
     */
    abstract public static function getDataTypes(): array;

    /**
     * Retorna un array con el nombre de todas las tablas de la base de datos.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0101
     *
     * @return array
     */
    abstract public static function getTables(): array;

    /**
     * Retorna el tipo de dato que se utiliza para los índices autoincrementados
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0108
     *
     * @return string
     */
    abstract public static function getIndexType(): string;

    /**
     * Retorna un array asociativo con la información de cada columna de la tabla.
     * El resultado será dependiente del motor de base de datos.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0108
     *
     * @param string $tableName
     *
     * @return array
     */
    abstract public static function getColumns(string $tableName): array;

    /**
     * Recibiendo un array con los datos de un campo tal y como lo retorna la base de
     * datos, devuelve la información normalizada para ser utilizada por Schema.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0108
     *
     * @param array $row
     *
     * @return array
     */
    abstract public static function normalizeDbField(array $row): array;

    abstract public static function yamlFieldToDb(array $data):array;
    abstract public static function yamlFieldToSchema(array $data):array;
    abstract public static function dbFieldToSchema(array $data):array;
    abstract public static function dbFieldToYaml(array $data):array;

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

    abstract public static function modify(string $tableName, array $oldField, array $newField):string;
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
