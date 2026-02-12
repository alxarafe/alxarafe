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
use Alxarafe\Lib\Routes;
use Alxarafe\Lib\Trans;
use Alxarafe\Tools\Debug;
use CoreModules\Admin\Model\Migration;
use Exception;
use stdClass;

/**
 * Class Config.
 * * Manages the application configuration file, migrations, and database seeders.
 */
abstract class Config
{
    protected const string CONFIG_FILENAME = 'config.json';

    public const array CONFIG_STRUCTURE = [
        'main' => ['path', 'url', 'data', 'theme', 'language', 'timezone'],
        'db' => ['type', 'host', 'user', 'pass', 'name', 'port', 'prefix', 'charset', 'collation', 'encryption', 'encrypt_type'],
        'security' => ['debug', 'unique_id', 'https', 'jwt_secret_key']
    ];

    private static ?stdClass $config = null;

    /**
     * Retrieves configuration. Reloads from disk if $reload is true.
     */
    public static function getConfig(bool $reload = false): ?stdClass
    {
        if ($reload || self::$config === null) {
            self::$config = self::loadConfig();
        }
        return self::$config;
    }

    /**
     * Updates and saves the configuration settings.
     */
    public static function setConfig(stdClass $data): bool
    {
        if (self::$config === null) {
            self::$config = new stdClass();
            self::$config->main = static::getDefaultMainFileInfo();
        }

        foreach (self::CONFIG_STRUCTURE as $section => $fields) {
            if (!isset($data->$section)) {
                continue;
            }

            self::$config->$section ??= new stdClass();

            foreach ($fields as $key) {
                if (isset($data->$section->$key)) {
                    self::$config->$section->$key = $data->$section->$key;
                }
            }
        }

        Trans::setLang(self::$config->main->language ?? Trans::FALLBACK_LANG);
        $saved = self::saveConfig();

        self::getConfig(true);
        Debug::initialize(true);

        return $saved;
    }

    public static function getDefaultMainFileInfo(): stdClass
    {
        return (object)[
            'path' => defined('BASE_PATH') ? constant('BASE_PATH') : '',
            'url'  => defined('BASE_URL') ? constant('BASE_URL') : '',
        ];
    }

    public static function saveConfig(): bool
    {
        if (self::$config === null) {
            return true;
        }

        $path = self::getConfigFilename();
        $json = json_encode(self::$config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        return file_put_contents($path, $json) !== false;
    }

    public static function getConfigFilename(): string
    {
        $base = defined('BASE_PATH') ? constant('BASE_PATH') : __DIR__;
        return dirname($base) . DIRECTORY_SEPARATOR . self::CONFIG_FILENAME;
    }

    /**
     * Executes pending database migrations.
     */
    public static function doRunMigrations(): bool
    {
        try {
            $config = static::getConfig();
            if ($config && isset($config->db)) {
                Database::createConnection($config->db);
            }

            $batch = Migration::getLastBatch() + 1;

            foreach (static::getMigrations() as $name => $path) {
                if (Migration::where('migration', $name)->exists()) {
                    continue;
                }

                $migration = require_once $path;
                $migration->up();

                Migration::create([
                    'migration' => $name,
                    'batch' => $batch,
                ]);
            }
            return true;
        } catch (Exception $e) {
            Messages::addError($e->getMessage());
            return false;
        }
    }

    /**
     * Collects all migrations from registered modules.
     */
    public static function getMigrations(): array
    {
        $routes = Routes::getAllRoutes();
        $migrations = $routes['Migrations'] ?? [];
        $result = [];

        foreach ($migrations as $module => $files) {
            foreach ($files as $filename => $entry) {
                $filepath = explode('|', $entry)[1] ?? '';
                if ($filepath) {
                    $result["{$filename}@{$module}"] = $filepath;
                }
            }
        }

        ksort($result);
        return $result;
    }

    /**
     * Runs database seeders for initial data population.
     */
    public static function runSeeders(): bool
    {
        $routes = Routes::getAllRoutes();
        $seeders = $routes['Seeders'] ?? [];

        foreach ($seeders as $moduleSeeders) {
            foreach ($moduleSeeders as $entry) {
                $className = explode('|', $entry)[0];
                if (class_exists($className)) {
                    try {
                        new $className();
                    } catch (Exception $e) {
                        Messages::addError($e->getMessage());
                        return false;
                    }
                }
            }
        }
        return true;
    }

    private static function loadConfig(): ?stdClass
    {
        $filename = self::getConfigFilename();
        if (!file_exists($filename)) {
            return null;
        }

        $content = file_get_contents($filename);
        if (!$content) {
            return null;
        }

        try {
            return json_decode($content, false, 512, JSON_THROW_ON_ERROR);
        } catch (Exception) {
            return null;
        }
    }
}
