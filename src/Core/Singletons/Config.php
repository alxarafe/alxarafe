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

namespace Alxarafe\Core\Singletons;

use Alxarafe\Core\Helpers\Auth;
use Alxarafe\Database\DB;
use Alxarafe\Database\Engine;
use Alxarafe\Database\SqlHelper;
use Exception;
use Symfony\Component\Yaml\Yaml;

class Config
{
    /**
     * Contains the full name of the configuration file or null
     *
     * @var string::null
     */
    private static string $configFilename;

    /**
     * Contains an array with the variables defined in the configuration file.
     * Use setVar to assign or getVar to access the variables of the array.
     *
     * @var array
     */
    private static array $global;

    /**
     * Contains the instance to the database engine (or null)
     *
     * @var Engine
     */
    public static Engine $dbEngine;

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

    /**
     * Contains the instance to the specific SQL engine helper (or null)
     *
     * @var sqlHelper
     */
    private static SqlHelper $sqlHelper;

    /**
     * It is a static instance of the Auth class that contains the data of the
     * currently identified user.
     *
     * @var Auth
     */
    private static Auth $user;

    /**
     * Contains the user's name or null
     *
     * @var string|null
     */
    private static ?string $username = null;

    private TemplateRender $render;
    private DebugTool $debug;

    public function __construct()
    {
        if (!isset(self::$global)) {
            self::$global = self::loadConfigurationFile();
            if (empty(self::$global)) {
                return false;
            }
        }
        self::defineConstants();
    }

    /**
     * Define todas las constantes de la sección 'constants' del archivo config.yaml
     * La sección constants contiene las constantes en grupos de tipo.
     * TODO: De momento se contempla boolean y el resto.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2022.1218
     *
     */
    private static function defineConstants()
    {
        foreach (self::$global['constants'] ?? [] as $type => $types) {
            foreach ($types as $name => $value) {
                switch ($type) {
                    case 'boolean':
                        define($name, in_array(strtolower($value), ['1', 'true']));
                        break;
                    default:
                        define($name, $value);
                }
            }
        }
    }

    /**
     * @throws DebugBarException
     */
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

    /**
     * Returns an array with the configuration defined in the configuration file.
     * If the configuration file does not exist, take us to the application
     * configuration form to create it
     *
     * @return array
     */
    public static function loadConfigurationFile(): array
    {
        $filename = self::getConfigFileName();
        if (isset($filename) && file_exists($filename)) {
            $yaml = file_get_contents($filename);
            if ($yaml) {
                return YAML::parse($yaml);
            }
        }
        return [];
    }

    /**
     * Returns the name of the configuration file. By default, create the config
     * folder and enter the config.yaml file inside it.
     * If you want to use another folder for the configuration, you will have to
     * define it in the constant CONFIGURATION_DIR before invoking this method,
     * this folder must exist.
     *
     * @return string|null
     */
    public static function getConfigFileName(): ?string
    {
        if (isset(self::$configFilename)) {
            return self::$configFilename;
        }
        $filename = constant('CONFIGURATION_DIR') . 'config.yaml';
        if (
            file_exists($filename) || is_dir(constant('CONFIGURATION_DIR')) || mkdir(constant('CONFIGURATION_DIR'), 0777, true)) {
            self::$configFilename = $filename;
        }
        return self::$configFilename;
    }

    /**
     * Gets the contents of a variable. If the variable does not exist, return null.
     *
     * @param string $module
     * @param string $section
     * @param string $name
     *
     * @return string|null ?string
     */
    public static function getVar(string $module, string $section, string $name): ?string
    {
        return self::$global[$module][$section][$name] ?? null;
    }

    /**
     * If self::$dbEngine contain null, create an Engine instance with the
     * database connection and assigns it to self::$dbEngine.
     *
     * @param string $db
     *
     * @return bool
     * @throws DebugBarException
     */
    public static function connectToDatabase($db = 'main'): bool
    {
        if (isset(self::$dbEngine)) {
            return true;
        }

        Config::$dbPrefix = strtolower(self::$global['database'][$db]['dbPrefix'] ?? '');
        Config::$dbName = strtolower(self::$global['database'][$db]['dbName']);

        $dbEngineName = self::$global['database'][$db]['dbEngineName'] ?? 'PdoMySql';
        $helperName = 'Sql' . substr($dbEngineName, 3);

        Debug::sqlMessage("Using '$dbEngineName' engine.");
        Debug::sqlMessage("Using '$helperName' SQL helper engine.");

        $sqlEngine = '\\Alxarafe\\Database\\SqlHelpers\\' . $helperName;
        $engine = '\\Alxarafe\\Database\\Engines\\' . $dbEngineName;
        try {
            self::$sqlHelper = new $sqlEngine();
            self::$dbEngine = new $engine([
                'dbUser' => self::$global['database'][$db]['dbUser'],
                'dbPass' => self::$global['database'][$db]['dbPass'],
                'dbName' => self::$global['database'][$db]['dbName'],
                'dbHost' => self::$global['database'][$db]['dbHost'],
                'dbPort' => self::$global['database'][$db]['dbPort'],
            ]);
            new DB();
            return isset(self::$dbEngine) && self::$dbEngine->connect() && self::$dbEngine->checkConnection();
        } catch (Exception $e) {
            Debug::addException($e);
        }
        return false;
    }

    public static function getEngine(): Engine
    {
        return self::$dbEngine;
    }

    public static function getSqlHelper(): SqlHelper
    {
        return self::$sqlHelper;
    }

    /**
     * Return true y the config file exists
     *
     * @return bool
     */
    public static function configFileExists(): bool
    {
        return (file_exists(self::getConfigFileName()));
    }

    public static function getUsername()
    {
        return self::$username;
    }

    /**
     * Set the display settings.
     *
     * @return void
     */
    public function loadViewsConfig()
    {
        dump(debug_backtrace());
        die('loadViewsConfig');
        Render::setSkin(self::getVar('templaterender', 'main', 'skin') ?? 'default');
        Render::setTemplate(self::getVar('templaterender', 'main', 'skin') ?? 'default');
    }

    /**
     * Stores all the variables in a permanent file so that they can be loaded
     * later with loadConfigFile()
     * Returns true if there is no error when saving the file.
     *
     * @return bool
     */
    public static function saveConfigFile(): bool
    {
        $configFile = self::getConfigFileName();
        if (!isset($configFile)) {
            return false;
        }
        return file_put_contents($configFile, YAML::dump(self::$global, 3)) !== false;
    }

    /**
     * Stores a variable.
     *
     * @param string $module
     * @param string $section
     * @param string $name
     * @param string $value
     */
    public static function setVar(string $module, string $section, string $name, string $value)
    {
        self::$global[$module][$section][$name] = $value;
    }
}
