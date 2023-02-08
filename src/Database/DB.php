<?php
/**
 * Copyright (C) 2022-2023  Rafael San José Tovar   <info@rsanjoseo.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace Alxarafe\Database;

use Alxarafe\Core\Singletons\Config;
use Alxarafe\Core\Singletons\Debug;
use Alxarafe\Core\Singletons\Translator;
use DebugBar\DebugBarException;
use Exception;

/**
 * Class DB
 *
 * Esta clase proporciona acceso directo a la base de datos.
 *
 * @author  Rafael San José Tovar <info@rsanjoseo.com>
 * @version 2022.0721
 *
 */
abstract class DB
{
    /**
     * Motor utilizado, puede ser 'MySql', 'MariaDB', 'PostgreSql' o cualquier otro PDO
     *
     * @var Engine
     */
    public static Engine $engine;

    /**
     * Instancia de la clase con el código SQL específico del motor.
     *
     * @var SqlHelper
     */
    public static SqlHelper $helper;

    /**
     * Prefijo de la base de datos en uso
     *
     * @var string
     */
    public static string $dbPrefix;

    /**
     * Nombre de la base de datos en uso
     *
     * @var string
     */
    public static string $dbName;

    /**
     * Establece conexión con una base de datos.
     *
     * TODO: La idea en un futuro, es que se pueda establecer conexión con múltiples
     *       bases de datos pasándole el nombre de la conexión.
     *       El problema es, cómo invocar de forma fácil qué conexión queremos.
     *       Si se mantiene como clase abstracta es complicado, lo más fácil sería
     *       creando una instancia para cada conexión, pero no se podría utilizar como
     *       clase abstracta (o ahora mismo, no caigo en cómo hacerlo).
     *
     * @param string $db
     *
     * @return bool
     */
    public static function connectToDatabase(string $db = 'main'): bool
    {
        // TODO: En un futuro, desearemos poder tener conexión con más de una base de datos.
        if (isset(self::$engine)) {
            return true;
        }

        $dbInfo = Config::getModuleVar('database');
        if (!isset($dbInfo[$db])) {
            Debug::sqlMessage(Translator::trans('empty-database-config', ['%name%' => $db]));
            return false;
        }

        self::$dbPrefix = strtolower($dbInfo[$db]['dbPrefix'] ?? '');
        self::$dbName = strtolower($dbInfo[$db]['dbName']);

        $engineName = $dbInfo[$db]['dbEngineName'] ?? 'PdoMySql';
        $helperName = 'Sql' . substr($engineName, 3);

        Debug::sqlMessage("Using '$engineName' engine.");
        Debug::sqlMessage("Using '$helperName' SQL helper engine.");

        $sqlEngine = '\\Alxarafe\\Database\\SqlHelpers\\' . $helperName;
        $engine = '\\Alxarafe\\Database\\Engines\\' . $engineName;
        try {
            self::$helper = new $sqlEngine();
            self::$engine = new $engine([
                'dbUser' => $dbInfo[$db]['dbUser'],
                'dbPass' => $dbInfo[$db]['dbPass'],
                'dbName' => self::$dbName,
                'dbHost' => $dbInfo[$db]['dbHost'],
                'dbPort' => $dbInfo[$db]['dbPort'],
            ]);
            return isset(self::$engine) && self::$engine->connect() && self::$engine->checkConnection();
        } catch (Exception $e) {
            Debug::addException($e);
        }
        return false;
    }

    /**
     * Ejecuta una sentencia SQL retornando TRUE si ha tenido éxito
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2022.0721
     *
     * @param string $query
     * @param array  $vars
     *
     * @return bool
     */
    public static function exec(string $query, array $vars = []): bool
    {
        return self::$engine->exec($query, $vars);
    }

    /**
     * Ejecuta una sentencia SELECT retornando 'false' si hay error, o un array
     * con el resultado de la consulta.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2022.0721
     *
     * @param string $query
     * @param array  $vars
     *
     * @return array|false
     */
    public static function select(string $query, array $vars = [])
    {
        return self::$engine->select($query, $vars);
    }

    /**
     * Retorna 'true' si la tabla existe en la base de datos.
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @param string $tableName
     *
     * @return bool
     */
    public static function tableExists(string $tableName): bool
    {
        return self::$helper->tableExists(self::$dbPrefix . $tableName);
    }

    /**
     * Retorna un array asociativo con los campos de la tabla
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @param string $tableName
     *
     * @return array
     */
    public static function getColumns(string $tableName): array
    {
        return self::$helper->getColumns(self::$dbPrefix . $tableName);
    }

    /**
     * Retorna un array asociativo con los índices de la tabla
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @param string $tableName
     *
     * @return array
     * @throws DebugBarException
     */
    public static function getIndexes(string $tableName): array
    {
        return self::$helper::getIndexes(DB::$dbPrefix . $tableName);
    }

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
    public static function createIndex(string $tableName, string $index, array $data): string
    {
        return self::$helper->createIndex(self::$dbPrefix . $tableName, $index, $data);
    }

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
    public static function changeIndex(string $tableName, string $index, array $oldData, array $newData): string
    {
        return self::$helper->changeIndex(self::$dbPrefix . $tableName, $index, $oldData, $newData);
    }

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
    public static function removeIndex(string $tableName, string $index): string
    {
        return self::$helper->removeIndex(self::$dbPrefix . $tableName, $index);
    }

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
    public static function modify(string $tableName, array $oldField, array $newField): string
    {
        return self::$helper->modify(self::$dbPrefix . $tableName, $oldField, $newField);
    }
}
