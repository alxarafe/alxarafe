<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Helpers;

use Alxarafe\Base\CacheCore;
use Alxarafe\Controllers\CreateConfig;
use Alxarafe\Database\Engine;
use Alxarafe\Database\SqlHelper;
use Alxarafe\Providers\Logger;
use Alxarafe\Providers\Translator;
use Exception;
use Symfony\Component\Cache\Adapter\PhpArrayAdapter;
use Symfony\Component\Yaml\Yaml;

/**
 * All variables and global functions are centralized through the static class Config.
 * The Config class can be instantiated and passed to the class that needs it, sharing the data and methods that are in
 * them.
 *
 * @package Alxarafe\Helpers
 */
class Config
{
    /**
     * Contains the instance to the database engine (or null)
     *
     * @var Engine
     */
    public static $dbEngine;

    /**
     * Contains a prefix for the database files
     *
     * @var string
     */
    public static $dbPrefix;

    /**
     * Contains the instance to the specific SQL engine helper (or null)
     *
     * @var sqlHelper
     */
    public static $sqlHelper;

    /**
     * Contains the database structure data.
     * Each table is a index of the associative array.
     *
     * @var array
     */
    public static $bbddStructure;

    /**
     * Contains the full name of the configuration file or null
     *
     * @var string::null
     */
    public static $configFilename;
    /**
     * Translator
     *
     * @var Translator
     */
    public static $lang;
    /**
     * Cache core engine.
     *
     * @var PhpArrayAdapter
     */
    public static $cacheEngine;
    /**
     * @var Session
     */
    public static $session;
    /**
     * Contains an array with the variables defined in the configuration file.
     * Use setVar to assign or getVar to access the variables of the array.
     *
     * @var array
     */
    private static $global;
    /**
     * Contains a message list.
     *
     * @var array
     */
    private static $messagesList;

    /**
     * Set the display settings.
     *
     * @return void
     */
    public static function loadViewsConfig(): void
    {
        Skin::setTemplatesEngine(self::getVar('templatesEngine') ?? 'twig');
        Skin::setSkin(self::getVar('skin') ?? 'default');
        Skin::setTemplate(self::getVar('template') ?? 'default');
        Skin::setCommonTemplatesFolder(self::getVar('commonTemplatesFolder') ?? Skin::COMMON_FOLDER);
    }

    /**
     * Gets the contents of a variable. If the variable does not exist, return null.
     *
     * @param string $name
     *
     * @return string|null
     */
    public static function getVar(string $name)
    {
        return self::$global[$name] ?? null;
    }

    /**
     * Initializes the global variable with the configuration, connects with the database and authenticates the user.
     *
     * @return void
     */
    public static function loadConfig(): void
    {
        self::$session = (new Session())->getSingleton();

        self::$messagesList = [];
        self::$global = self::loadConfigurationFile();

        if (self::$lang === null) {
            self::$lang = new Translator(Config::$global['language'] ?? constant('LANG'));
        }
        if (isset(self::$global['skin'])) {
            $templatesFolder = constant('BASE_PATH') . Skin::SKINS_FOLDER;
            $skinFolder = $templatesFolder . '/' . self::$global['skin'];
            if (is_dir($templatesFolder) && !is_dir($skinFolder)) {
                Config::setError("Skin folder '$skinFolder' does not exists!");
                (new CreateConfig())->index();
                return;
            }
            Skin::setSkin(self::$global['skin']);
        }
        if (empty(self::$global) || !self::connectToDataBase()) {
            self::setError('Database Connection error...');
            (new CreateConfig())->index();
            return;
        }
        self::$cacheEngine = (new CacheCore())->getEngine();
    }

    /**
     * Returns an array with the configuration defined in the configuration file.
     * If the configuration file does not exist, take us to the application configuration form to create it
     *
     * @return array
     */
    public static function loadConfigurationFile(): array
    {
        if (!self::configFileExists()) {
            (new CreateConfig())->index();
        }

        $filename = self::getConfigFileName();
        if (isset($filename) && file_exists($filename) && is_file($filename)) {
            $yaml = file_get_contents($filename);
            if ($yaml) {
                return Yaml::parse($yaml);
            }
        }
        return [];
    }

    /**
     * Return true y the config file exists
     *
     * @return bool
     */
    public static function configFileExists(): bool
    {
        return (file_exists(self::getConfigFileName()) && is_file(self::getConfigFileName()));
    }

    /**
     * Returns the name of the configuration file. By default, create the config folder and enter the config.yaml file
     * inside it. If you want to use another folder for the configuration, you will have to define it in the constant
     * CONFIGURATION_PATH before invoking this method, this folder must exist.
     *
     * @return string
     */
    public static function getConfigFileName(): string
    {
        if (isset(self::$configFilename)) {
            return self::$configFilename;
        }
        $filename = CONFIGURATION_PATH . '/config.yaml';
        if (file_exists($filename) || is_dir(CONFIGURATION_PATH) || mkdir(CONFIGURATION_PATH, 0777, true)) {
            self::$configFilename = $filename;
        }
        return self::$configFilename;
    }

    /**
     * Register a new error message
     *
     * @param string $msg
     */
    public static function setError(string $msg): void
    {
        self::$messagesList[] = [
            'type' => 'danger',
            'msg' => $msg,
        ];
        self::$session->setFlash('messages', self::$messagesList);
    }

    /**
     * If Config::$dbEngine contain null, create an Engine instance with the database connection and assigns it to
     * Config::$dbEngine.
     *
     * @return bool
     */
    public static function connectToDatabase(): bool
    {
        if (self::$dbEngine == null) {
            $dbEngineName = self::$global['dbEngineName'] ?? 'PdoMySql';
            $helperName = 'Sql' . substr($dbEngineName, 3);

            $sqlEngine = '\\Alxarafe\\Database\\SqlHelpers\\' . $helperName;
            $engine = '\\Alxarafe\\Database\\Engines\\' . $dbEngineName;
            try {
                Config::$sqlHelper = new $sqlEngine();
                Config::$dbEngine = new $engine([
                    'dbUser' => self::$global['dbUser'],
                    'dbPass' => self::$global['dbPass'],
                    'dbName' => self::$global['dbName'],
                    'dbHost' => self::$global['dbHost'],
                    'dbPort' => self::$global['dbPort'],
                ]);
            } catch (Exception $e) {
                Logger::getInstance()::exceptionHandler($e);
                Config::setError($e->getMessage());
                return false;
            }
        }

        return isset(self::$dbEngine) && self::$dbEngine->connect() && Config::$dbEngine->checkConnection();
    }

    /**
     * Return the default Cache Core.
     *
     * @return PhpArrayAdapter
     */
    public static function getCacheCoreEngine(): PhpArrayAdapter
    {
        return self::$cacheEngine;
    }

    /**
     * Register a new warning message
     *
     * @param string $msg
     */
    public static function setWarning(string $msg): void
    {
        self::$messagesList[] = [
            'type' => 'warning',
            'msg' => $msg,
        ];
        self::$session->setFlash('messages', self::$messagesList);
    }

    /**
     * Register a new info message
     *
     * @param string $msg
     */
    public static function setInfo(string $msg): void
    {
        self::$messagesList[] = [
            'type' => 'info',
            'msg' => $msg,
        ];
        self::$session->setFlash('messages', self::$messagesList);
    }

    /**
     * Register a new error message
     *
     * @param string $msg
     */
    public static function setSuccess(string $msg): void
    {
        self::$messagesList[] = [
            'type' => 'success',
            'msg' => $msg,
        ];
        self::$session->setFlash('messages', self::$messagesList);
    }

    /**
     * Stores all the variables in a permanent file so that they can be loaded later with loadConfigFile()
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
        return file_put_contents($configFile, Yaml::dump(self::$global)) !== false;
    }

    /**
     * Returns an array with the messages, and empties the list.
     *
     * @return array
     */
    public static function getMessages(): array
    {
        $list = self::$messagesList;
        self::$messagesList = [];
        return $list;
    }

    /**
     * Stores a variable.
     *
     * @param string $name
     * @param string $value
     */
    public static function setVar(string $name, string $value): void
    {
        self::$global[$name] = $value;
    }

    /**
     * @param $dbEngine
     */
    public static function setDbEngine($dbEngine)
    {
        self::$dbEngine = $dbEngine;
    }

    /**
     * @param $globals
     */
    public static function setGlobals($globals)
    {
        self::$global = $globals;
    }

    /**
     * @param $lang
     */
    public static function setLang($lang)
    {
        self::$lang = $lang;
    }

    /**
     * @param $session
     */
    public static function setSession($session)
    {
        self::$session = $session;
    }
}
