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

use Alxarafe\Core\Helpers\Auth;
use Alxarafe\Core\Singletons\Config;
use Alxarafe\Core\Singletons\Debug;
use Alxarafe\Core\Singletons\FlashMessages;
use Alxarafe\Database\SqlHelpers\SqlMySql;
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
abstract class DB
{
    /**
     * Motor utilizado, puede ser MySql, MariaDB, PostgreSql o cualquier otro PDO
     *
     * @var Engine
     */
    public static $engine;

    /**
     * Instancia de la clase con el código SQL específico del motor.
     *
     * @var SqlHelper
     */
    public static $helper;

    /**
     * Database name.
     *
     * @var string
     */
    public static string $dbName;

    /**
     * Contains de database tablename prefix
     *
     * @var string
     */
    public static string $dbPrefix;

    public static $user;
    public static $username;

    /**
     * Establece conexión con la base de datos
     *
     * @param string $db
     *
     * @return bool
     * @throws DebugBarException
     */
    public static function connectToDatabase($db = 'main'): bool
    {
        if (isset(self::$engine)) {
            return true;
        }

        $dbInfo = Config::getModuleVar('database');
        if ($dbInfo === null) {
            Debug::sqlMessage('empty-database-config');
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
                'dbName' => $dbInfo[$db]['dbName'],
                'dbHost' => $dbInfo[$db]['dbHost'],
                'dbPort' => $dbInfo[$db]['dbPort'],
            ]);
            return isset(self::$engine) && self::$engine->connect() && self::$engine->checkConnection();
        } catch (Exception $e) {
            Debug::addException($e);
        }
        return false;
    }

    public function __construct()
    {
        self::$engine = Config::getEngine();
        self::$helper = Config::getSqlHelper();
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

    public static function getDataTypes()
    {
        return self::$helper->getDataTypes();
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

    public static function tableExists(string $tableName)
    {
        return self::$helper->tableExists(self::$dbPrefix . $tableName);
    }

    public static function getColumns(string $tableName)
    {
        return self::$helper->getColumns(self::$dbPrefix . $tableName);
    }

    public static function yamlFieldToDb(array $data): array
    {
        return self::$helper::yamlFieldToDb($data);
    }

    public static function yamlFieldToSchema(array $data): array
    {
        return self::$helper::yamlFieldToSchema($data);
    }

    public static function dbFieldToSchema(array $data): array
    {
        return self::$helper::dbFieldToSchema($data);
    }

    public static function dbFieldToYaml(array $data): array
    {
        return self::$helper::dbFieldToYaml($data);
    }

    public static function normalizeFromDb(array $data)
    {
        $result = self::$helper::normalizeDbField($data);
        dump([
            'normalizeFromDb',
            'data' => $data,
            'result' => $result,
        ]);
        return $result;
    }

    public static function normalizeFromYaml(array $yamlFields)
    {
        $result = [];
        foreach ($yamlFields as $field => $yamlField) {
            $result[$field] = self::$helper::normalizeYamlField($yamlField);
        }
        dump([
            'normalizeFromYaml',
            'data' => $yamlFields,
            'result' => $result,
        ]);
        return $result;
    }

    public static function normalize(array $data)
    {
        return self::$helper->normalizeField($data);
    }

    public static function getIndexType(): string
    {
        return self::$helper->getIndexType();
    }

    public static function modify(string $tableName, array $oldField, array $newField): string
    {
        return self::$helper->modify(self::$dbPrefix . $tableName, $oldField, $newField);
    }

    public static function getUsername()
    {
        return self::$username;
    }

    public static function connectToDatabaseAndAuth(): bool
    {
        if (!self::connectToDataBase()) {
            FlashMessages::setError('Database Connection error...');
            return false;
        }
        if (!isset(self::$user)) {
            self::$user = new Auth();
            self::$username = self::$user->getUser();
            if (self::$username === null) {
                self::$user->login();
            }
        }
        return true;
    }

}
