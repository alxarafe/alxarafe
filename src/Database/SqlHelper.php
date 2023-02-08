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
    public static array $types;

    public function __construct()
    {
        self::$types = static::getDataTypes();
    }

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
    abstract public static function _getIndexType(): string;

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
     * Obtiene un array asociativo con los índices de la tabla
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @param string $tableName
     *
     * @return array
     */
    abstract public static function getIndexes(string $tableName): array;

    /**
     * Retorna la sentencia SQL para la creación de un índice
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @param string $tableName
     * @param string $index
     * @param array  $data
     *
     * @return string
     */
    abstract public static function createIndex(string $tableName, string $index, array $data): string;

    /**
     * Retorna la sentencia SQL para cambiar un índice o constraint
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @param string $tableName
     * @param string $index
     * @param array  $oldData
     * @param array  $newData
     *
     * @return string
     */
    abstract public static function changeIndex(string $tableName, string $index, array $oldData, array $newData): string;

    /**
     * Retorna la sentencia SQL para la eliminación de un índice
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @param string $tableName
     * @param string $index
     *
     * @return string
     */
    abstract public static function removeIndex(string $tableName, string $index): string;

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
    abstract public static function _normalizeDbField(array $row): array;

    /**
     * Recibe los datos del yaml de definición de un campo, y retorna la información
     * necesaria para la creación del campo en la base de datos.
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @param array $data
     *
     * @return array
     */
    abstract public static function yamlFieldToDb(array $data): array;

    /**
     * Recibe los datos del yaml de definición de los índices, y retorna la información
     * necesaria para la creación de los mismos en la base de datos.
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @param array $data
     *
     * @return array
     */
    abstract public static function yamlIndexToDb(array $data): array;

    /**
     * Toma la estructura de un campo obtenida de la base de datos, y la retorna
     * de la misma forma en la que se usó al ser creada.
     * Esto es necesario, porque algunas bases de datos cambian tipos como boolean por
     * tinyint(1), o int por int(10)
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @param string $genericType
     * @param array  $structure
     *
     * @return array
     */
    abstract public static function sanitizeDbStructure(string $genericType, array $structure): array;

    /**
     * Obtiene la secuencia SQL para la creación o edición de una columna
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @param array $column
     *
     * @return string
     */
    abstract public static function getSqlField(array $column): string;

    /**
     * Retorna un array con el nombre, tamaño, mínimo y máximo valor para un tipo
     * entero de tamaño size. El tamaño se ajustará al primero disponible, retornando
     * el tamaño real asumido.
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @param int  $size
     * @param bool $unsigned
     *
     * @return array
     */
    abstract public static function getIntegerMinMax(int $size, bool $unsigned): array;

    /**
     * Obtiene la secuencia SQL para listar los índices de la tabla.
     *
     * @param string $tableName
     *
     * @return string
     */
    abstract public static function getIndexesSql(string $tableName): string;

    /**
     * Retorna un array con la información del índice, y de la constraint si existe.
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @param array $fields
     *
     * @return array
     */
    abstract public static function normalizeIndexes(array $fields): array;

    /**
     * Retorna la secuencia SQL para modificar un campo de la tabla
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @param string $tableName
     * @param array  $oldField
     * @param array  $newField
     *
     * @return string
     */
    abstract public static function modify(string $tableName, array $oldField, array $newField): string;
}
