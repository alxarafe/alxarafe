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

use PDO;

/**
 * Class DB
 *
 * Esta clase proporciona acceso directo a la base de datos.
 *
 * @author  Rafael San José Tovar <info@rsanjoseo.com>
 * @version 2022.0721
 *
 */
class DB
{
    /**
     * Motor utilizado, puede ser MySql, MariaDB, PostgreSql o cualquier otro PDO
     *
     * @var Engine
     */
    public static $engine;

    public function __construct()
    {
        if (!isset(self::$engine)) {
            $config = [
                'dbName' => constant('FS_DB_NAME'),
                'dbUser' => constant('FS_DB_USER'),
                'dbPass' => constant('FS_DB_PASS'),
                'dbHost' => constant('FS_DB_HOST'),
                'dbPort' => constant('FS_DB_PORT'),
                'dbOptions' => [
                    // PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ],
            ];

            $engine = constant('FS_DB_TYPE');
            switch (mb_strtolower($engine)) {
                case 'mysql':
                    self::$engine = new MySql($config);
                    break;
                case 'mariadb':
                    self::$engine = new MariaDb($config);
                    break;
                case 'postgresql':
                    self::$engine = new PostgreSql($config);
                    break;
                default:
                    die('Unknown engine: ' . $engine);
            }
        }
    }

    public static function connect()
    {
        return self::$engine->connect();
    }

    public static function disconnect()
    {
        return self::$engine->disconnect();
    }

    public static function connected()
    {
        return self::$engine->connected();
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
     * Ejecuta una sentencia SELECT, retornando false si hay error, o un array
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

    public static function getErrors()
    {
        return self::$engine->getErrors();
    }

    public static function beginTransaction()
    {
        return self::$engine->beginTransaction();
    }

    public static function commit()
    {
        return self::$engine->commit();
    }

    public static function close()
    {
        return self::$engine->close();
    }

    public static function rollback()
    {
        return self::$engine->rollback();
    }

    public static function version()
    {
        return self::$engine->server_info();
    }
}
