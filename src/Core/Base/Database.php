<?php

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace Alxarafe\Base;

use Alxarafe\Lib\Messages;
use Alxarafe\Lib\Trans;
use Alxarafe\Tools\Debug;
use DebugBar\DataCollector\PDO\PDOCollector;
use Illuminate\Database\Capsule\Manager as CapsuleManager;
use PDO;
use PDOException;
use stdClass;

/**
 * Class Database.
 *
 * Extends Illuminate Capsule to manage database connections,
 * schema creation, and DebugBar integration.
 *
 * @package Alxarafe\Base
 */
class Database extends CapsuleManager
{
    /**
     * Initializes the database connection and Eloquent ORM.
     *
     * @param stdClass $db Configuration object.
     */
    public function __construct(stdClass $db)
    {
        parent::__construct();

        $this->addConnection([
            'driver'    => $db->type ?? 'mysql',
            'host'      => $db->host ?? 'localhost',
            'database'  => $db->name,
            'username'  => $db->user,
            'password'  => $db->pass,
            'charset'   => $db->charset ?? 'utf8mb4',
            'collation' => $db->collation ?? 'utf8mb4_unicode_ci',
            'prefix'    => $db->prefix ?? '',
        ]);

        $this->setAsGlobal();
        $this->bootEloquent();

        // DebugBar Integration
        $debugBar = Debug::getDebugBar();
        if ($debugBar && !$debugBar->hasCollector('pdo')) {
            $pdo = $this->getConnection()->getPdo();
            $debugBar->addCollector(new PDOCollector($pdo));
        }
    }

    /**
     * Supported database drivers.
     */
    public static function getDbDrivers(): array
    {
        return [
            'mysql' => 'MySQL',
            'pgsql' => 'PostgreSQL',
        ];
    }

    /**
     * Validates connection and optionally creates the database.
     */
    public static function checkDatabaseConnection(stdClass $data, bool $create = false): bool
    {
        if (!static::checkIfDatabaseExists($data, true)) {
            return $create && static::createDatabaseIfNotExists($data);
        }
        return true;
    }

    /**
     * Checks if a specific database exists on the server.
     */
    public static function checkIfDatabaseExists(stdClass $data, bool $quiet = false): bool
    {
        if (!static::checkConnection($data, $quiet)) {
            return false;
        }

        $dsn = "{$data->type}:host={$data->host};dbname={$data->name};charset={$data->charset}";
        try {
            new PDO($dsn, $data->user, $data->pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            return true;
        } catch (PDOException $e) {
            if (!$quiet) {
                Messages::addError(Trans::_('error_message', ['message' => $e->getMessage()]));
            }
            return false;
        }
    }

    /**
     * Checks if the database engine (server) is reachable.
     */
    public static function checkConnection(stdClass $data, bool $quiet = false): bool
    {
        $dsn = "{$data->type}:host={$data->host}";
        try {
            new PDO($dsn, $data->user, $data->pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_TIMEOUT => 5
            ]);
            return true;
        } catch (PDOException $e) {
            if (!$quiet) {
                Messages::addError(Trans::_('error_message', ['message' => $e->getMessage()]));
            }
            return false;
        }
    }

    /**
     * Attempts to create the database schema.
     */
    public static function createDatabaseIfNotExists(stdClass $data): bool
    {
        if (static::checkIfDatabaseExists($data, true)) {
            return true;
        }

        $dsn = "{$data->type}:host={$data->host}";
        try {
            $pdo = new PDO($dsn, $data->user, $data->pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            // Secure database name string
            $dbName = str_replace(['`', ';'], '', $data->name);
            $pdo->exec("CREATE DATABASE `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            return true;
        } catch (PDOException $e) {
            Messages::addError($e->getMessage());
            Messages::addError(Trans::_('pdo_fail_db_creation', ['message' => $e->getMessage()]));
            return false;
        }
    }
}