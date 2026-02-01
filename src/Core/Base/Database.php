<?php

/* Copyright (C) 2024      Rafael San José      <rsanjose@alxarafe.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace Alxarafe\Base;

use Alxarafe\Lib\Messages;
use Alxarafe\Lib\Trans;
use Alxarafe\Tools\Debug;
use DebugBar\DataCollector\PDO\PDOCollector;
use DebugBar\DebugBarException;
use Illuminate\Database\Capsule\Manager as CapsuleManager;
use PDO;
use PDOException;
use stdClass;

/**
 * Create a PDO database connection
 *
 * @package Alxarafe\Base
 */
class Database extends CapsuleManager
{
    /**
     * Construct the database access
     *
     * @param stdClass $db
     *
     * @throws DebugBarException
     */
    public function __construct(stdClass $db)
    {
        parent::__construct();

        $this->addConnection([
            'driver' => $db->type,
            'host' => $db->host,
            'database' => $db->name,
            'username' => $db->user,
            'password' => $db->pass,
            'charset' => $db->charset,
            'collation' => $db->collation,
            'prefix' => $db->prefix,
        ]);

        $this->setAsGlobal();
        $this->bootEloquent();

        $debugBar = Debug::getDebugBar();
        if (!isset($debugBar) || $debugBar->hasCollector('pdo')) {
            return;
        }

        $pdo = $this->getConnection()->getPdo();
        $debugBar->addCollector(new PDOCollector($pdo));
    }

    public static function getDbDrivers(): array
    {
        return [
            'mysql' => 'MySQL',
            'pgsql' => 'PostgreSQL',
        ];
    }

    /**
     * Checks if the connection to the database is possible with the parameters
     * defined in the configuration file.
     *
     * @param stdClass $data
     * @param bool $create
     * @return bool
     */
    public static function checkDatabaseConnection(stdClass $data, bool $create = false): bool
    {
        if (!static::checkIfDatabaseExists($data, true)) {
            if (!$create) {
                return false;
            }
            if (!static::createDatabaseIfNotExists($data, true)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Returns true if the database already exists.
     *
     * @param stdClass $data
     * @return bool
     */
    public static function checkIfDatabaseExists(stdClass $data, bool $quiet = false): bool
    {
        if (!static::checkConnection($data, true)) {
            return false;
        }

        $dsn = "$data->type:host=$data->host;dbname=$data->name;charset=$data->charset";
        try {
            new PDO($dsn, $data->user, $data->pass);
        } catch (PDOException $e) {
            if (!$quiet) {
                Messages::addError(Trans::_('error_message', ['message' => $e->getMessage()]));
            }
            return false;
        }
        return true;
    }

    /**
     * Checks if there is a connection to the database engine.
     *
     * @param stdClass $data
     * @param bool $quiet
     * @return bool
     */
    public static function checkConnection(stdClass $data, bool $quiet = false): bool
    {
        $dsn = "$data->type:host=$data->host";
        try {
            new PDO($dsn, $data->user, $data->pass);
        } catch (PDOException $e) {
            if (!$quiet) {
                Messages::addError(Trans::_('error_message', ['message' => $e->getMessage()]));
            }
            return false;
        }
        return true;
    }

    /**
     * Creates the database if it does not exist. Returns true if the creation succeeds.
     *
     * @param stdClass $data
     * @return bool
     */
    public static function createDatabaseIfNotExists(stdClass $data): bool
    {
        if (static::checkIfDatabaseExists($data, true)) {
            return true;
        }

        $dsn = "$data->type:host=$data->host";
        try {
            $pdo = new PDO($dsn, $data->user, $data->pass);
            $pdo->exec('CREATE DATABASE ' . $data->name);
            return true;
        } catch (PDOException $e) {
            Messages::addError($e->getMessage());
            Messages::addError(Trans::_('pdo_fail_db_creation', ['message' => $e->getMessage()]));
            return false;
        }
    }
}
