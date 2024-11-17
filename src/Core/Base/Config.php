<?php

/* Copyright (C) 2024       Rafael San José         <rsanjose@alxarafe.com>
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

use Alxarafe\Lib\Routes;
use Alxarafe\Lib\Trans;
use Alxarafe\Tools\Debug;
use CoreModules\Admin\Model\Migration;
use DebugBar\DebugBarException;
use stdClass;

/**
 * Manage the configuration file
 */
abstract class Config
{
    /**
     * Configuration filename.
     */
    private const CONFIG_FILENAME = 'config.json';

    /**
     * Defines the configuration file structure
     */
    public const  CONFIG_STRUCTURE = [
        'main' => [
            'path', // Path to the public folder (usually htdocs)
            'url',
            'data', // Route to the private folder that stores the documents.
            'theme',
            'language',
        ],
        'db' => [
            'type',
            'host',
            'user',
            'pass',
            'name',
            'port',
            'prefix',
            'charset',
            'collation',
            'encryption', // Pending review: If true, some database fields are encrypted.
            'encrypt_type', // Pending review: Encryption type ('0' if none, '1' if DES and '2' if AES)
        ],
        'security' => [
            'debug',
            'unique_id', // Unique identifier of the installation.
            'https', // If true, the use of https is forced (recommended)
            'jwt_secret_key',
        ]
    ];

    /**
     * Contains configuration file information
     *
     * @var stdClass|null
     */
    private static ?stdClass $config = null;

    private static array $messages = [];

    /**
     * Returns an array with the messages accumulated since the last call.
     *
     * @return array
     */
    public static function getMessages()
    {
        $result = self::$messages;
        self::$messages = [];
        return $result;
    }

    /**
     * Gets the information defined in the configuration file.
     * To reload the configuration file, set $reload to true.
     *
     * @param bool $reload
     * @return stdClass|null
     */
    public static function getConfig(bool $reload = false): ?stdClass
    {
        if ($reload || !isset(self::$config)) {
            self::$config = self::loadConfig($reload);
        }

        return self::$config;
    }

    /**
     * Add the configuration parameters received in $data in the configuration file.
     *
     * @param stdClass $data
     * @return bool
     * @throws DebugBarException
     */
    public static function setConfig(stdClass $data): bool
    {
        /**
         * If the configuration file is empty, we add the parameters
         * that we can obtain at runtime (getDefaultMainFileInfo).
         */
        if (empty(self::$config)) {
            self::$config = new stdClass();
            self::$config->main = static::getDefaultMainFileInfo();
        }

        foreach (self::CONFIG_STRUCTURE as $section => $values) {
            foreach ($values as $key) {
                if (!isset($data->$section)) {
                    error_log($section . ' is not defined!');
                    continue;
                }
                if (!isset($data->$section->$key)) {
                    error_log($key . ' is not defined in ' . $section . '!');
                    continue;
                }
                if (!isset(self::$config->$section)) {
                    self::$config->$section = new stdClass();
                }
                self::$config->$section->$key = $data->$section->$key;
            }
        }

        /**
         * Save the configuration in the configuration file.
         */
        Trans::setLang(self::$config->main->language ?? Trans::FALLBACK_LANG);
        $ok = self::saveConfig();
        self::getConfig(true);
        Debug::initialize(true);
        return $ok;
    }

    /**
     * Those configuration parameters that we can obtain at run time,
     * or their default values, are obtained.
     *
     * @return stdClass
     */
    public static function getDefaultMainFileInfo(): stdClass
    {
        $result = new stdClass();
        $result->path = constant('BASE_PATH');
        $result->url = constant('BASE_URL');
        return $result;
    }

    /**
     * Updates the configuration file with the information it has in memory.
     *
     * @return bool
     */
    private static function saveConfig(): bool
    {
        if (empty(self::$config)) {
            return true;
        }
        return file_put_contents(self::getConfigFilename(), json_encode(self::$config, JSON_PRETTY_PRINT)) !== false;
    }

    /**
     * Returns the config.json complete path.
     *
     * @return string
     */
    private static function getConfigFilename(): string
    {
        return realpath(constant('BASE_PATH') . '/..') . DIRECTORY_SEPARATOR . self::CONFIG_FILENAME;
    }

    /**
     * Obtains an associative array with all migrations. The index is the name of the
     * migration and the name of the module separated by an @ sign, which ensures that
     * the migration is registered as executed; and the value is the relative path of
     * the file containing the migration.
     *
     * @return array
     */
    private static function getMigrations(): array
    {
        $result = [];

        $routes = Routes::getAllRoutes();
        if (empty($routes['Migrations'])) {
            return $result;
        }

        $migrations = $routes['Migrations'];

        foreach ($migrations as $module => $data) {
            foreach ($data as $filename => $migration) {
                $route_array = explode('|', $migration);
                $filepath = $route_array[1];

                $result[$filename . '@' . $module] = $filepath;
            }
        }
        ksort($result);

        return $result;
    }

    /**
     * Runs pending migrations in alphabetical order.
     * By default, migration names are preceded by the date in Japanese format,
     * which ensures chronological execution.
     *
     * @return void
     */
    public static function runMigrations(): void
    {
        $result = static::getMigrations();

        $batch = 1 + Migration::getLastBatch();
        foreach ($result as $filename => $filepath) {
            if (Migration::where(['migration' => $filename])->first()) {
                continue;
            }

            $migration = require_once $filepath;
            $migration->up();
            Migration::create([
                'migration' => $filename,
                'batch' => $batch,
            ]);
        }
    }

    public static function runSeeders()
    {
        $routes = Routes::getAllRoutes();
        if (empty($routes['Seeders'])) {
            return;
        }

        $seeders = $routes['Seeders'];

        $result = [];
        foreach ($seeders as $data) {
            foreach ($data as $seeder) {
                $route_array = explode('|', $seeder);
                $classname = $route_array[0];
                new $classname();
            }
        }
    }

    /**
     * Adds a new message that will then be returned by getMessages.
     *
     * @param $message
     * @return void
     */
    private static function addNewMessage($message)
    {
        self::$messages[] = $message;
    }

    /**
     * Returns a stdClass with the program configuration.
     * If the configuration file does not exist, is not accessible, or is not correct, returns null.
     * The configuration is loaded from the file only once and stored in a variable. You can set $reload
     * to true to force a reload of the configuration file.
     *
     * @param bool $reload
     * @return stdClass|null
     */
    private static function loadConfig(bool $reload = false): ?stdClass
    {
        if (!$reload && isset(self::$config)) {
            return self::$config;
        }

        $filename = self::getConfigFilename();
        if (!file_exists($filename)) {
            return null;
        }

        $config = file_get_contents($filename);
        if ($config === false) {
            return self::$config;
        }

        $result = json_decode($config);
        if (json_last_error() === JSON_ERROR_NONE) {
            self::$config = $result;
        }

        return $result;
    }
}
