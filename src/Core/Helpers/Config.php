<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Helpers;

use Alxarafe\Controllers\EditConfig;
use Alxarafe\Database\Engine;
use Alxarafe\Database\SqlHelper;
use Exception;
use Symfony\Component\Yaml\Yaml;

/**
 * All variables and global functions are centralized through the static class Config.
 * The Config class can be instantiated and passed to the class that needs it,
 * sharing the data and methods that are in them.
 * 
 * @package Alxarafe\Helpers
 */
class Config
{

    /**
     * Contains an array with the variables defined in the configuration file.
     * Use setVar to assign or getVar to access the variables of the array.
     *
     * @var array
     */
    static private $global;

    /**
     * Contains error messages.
     *
     * @var array
     */
    static private $errors;

    /**
     * Contains the instance to the database engine (or null)
     * 
     * @var Engine
     */
    static $dbEngine;

    /**
     * Contains the instance to the specific SQL engine helper (or null)
     *
     * @var sqlHelper
     */
    static $sqlHelper;

    /**
     * Contains the database structure data.
     * Each table is a index of the associative array.
     *
     * @var array
     */
    static $bbddStructure;

    /**
     * It is a static instance of the Auth class that contains the data of the
     * currently identified user.
     *
     * @var Auth
     */
    static $user;
    /**
     * TODO: Undocummented
     *
     * @var
     */
    static $username;
    /**
     * TODO: Undocummented
     *
     * @var
     */
    static $configFilename;

    /**
     * Returns the name of the configuration file. By default, create the config
     * folder and enter the config.yaml file inside it.
     * If you want to use another folder for the configuration, you will have to
     * define it in the constant CONFIGURATION_PATH before invoking this method,
     * this folder must exist.
     *
     * @return string|null
     */
    public static function getConfigFileName()// : ?string - NetBeans only supports up to php7.0, for this you need php7.1
    {
        if (isset(self::$configFilename)) {
            return self::$configFilename;
        }
        $filename = CONFIGURATION_PATH . '/config.yaml';
        if (file_exists($filename) || is_dir(CONFIGURATION_PATH) || mkdir(CONFIGURATION_PATH, 0777, true)) {
            return $filename;
        }
        return null;
    }

    /**
     * TODO: Undocumented
     *
     * @return bool
     */
    public static function configFileExists(): bool
    {
        return (file_exists(self::getConfigFileName()));
    }

    /**
     * TODO: Undocumented
     *
     * @return array
     */
    public static function loadConfigurationFile(): array
    {
        $filename = self::getConfigFileName();
        if (isset($filename)) {
            if (!self::configFileExists()) {
                (new EditConfig())->run();
            }
            $yaml = file_get_contents($filename);
            if ($yaml) {
                return YAML::parse($yaml);
            }
        }
        return null;
    }

    /**
     * TODO: Undocummented
     */
    public static function loadViewsConfig()
    {
        Skin::setTemplatesEngine(self::getVar('templatesEngine') ?? 'twig');
        Skin::setSkin(self::getVar('skin') ?? 'default');
        Skin::setTemplate(self::getVar('template') ?? 'default');
        Skin::setCommonTemplatesFolder(self::getVar('commonTemplatesFolder') ?? BASE_PATH . Skin::COMMON_FOLDER);
    }

    /**
     * TODO: Undocummented
     */
    public static function loadConfig()
    {
        self::$global = self::loadConfigurationFile();
        if (isset(self::$global['skin'])) {
            $templatesFolder = BASE_PATH . Skin::SKINS_FOLDER;
            $skinFolder = $templatesFolder . '/' . self::$global['skin'];
            if (is_dir($templatesFolder) && !is_dir($skinFolder)) {
                Config::setError("Skin folder '$skinFolder' does not exists!");
                (new EditConfig())->run();
                die;
            }
            Skin::setSkin(self::$global['skin']);
        }
        if (!self::connectToDataBase()) {
            self::setError('Database Connection error...');
            (new EditConfig())->run();
            die;
        }
        if (self::$user === null) {
            self::$user = new Auth();
            self::$username = self::$user->getUser();
            if (self::$username == null) {
                self::$user->login();
            }
        }
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
        $configFile = self::getConfigurationFile();
        if (!isset($configFile)) {
            return false;
        }
        return file_put_contents($configFile, YAML::dump(self::$global)) !== FALSE;
    }

    /**
     * TODO: Undocumented
     *
     * @param string $error
     */
    public static function setError(string $error)
    {
        self::$errors[] = $error;
    }

    /**
     * TODO: Undocumented
     *
     * @return array
     */
    public static function getErrors()
    {
        $errors = self::$errors;
        self::$errors = [];
        return $errors;
    }

    /**
     * Stores a variable.
     * 
     * @param string $name
     * @param string $value
     */
    public static function setVar(string $name, string $value)
    {
        self::$global[$name] = $value;
    }

    /**
     * Gets the contents of a variable. If the variable does not exist, return null.
     *
     * @param string $name
     *
     * @return string|null
     */
    public static function getVar(string $name)// : ?string - NetBeans only supports up to php7.0, for this you need php7.1
    {
        return self::$global[$name] ?? null;
    }

    /**
     * If Config::$dbEngine contain null, create an Engine instance with the
     * database connection and assigns it to Config::$dbEngine.
     *
     * @return bool
     *
     * @throws \DebugBar\DebugBarException
     */
    public static function connectToDatabase(): bool
    {
        if (self::$dbEngine == null) {
            $dbEngineName = self::$global['dbEngineName'] ?? 'PdoMySql';
            $helperName = 'Sql' . substr($dbEngineName, 3);

            Debug::addMessage('SQL', "Using '$dbEngineName' engine.");
            Debug::addMessage('SQL', "Using '$helperName' SQL helper engine.");

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
                return isset(self::$dbEngine) && self::$dbEngine->connect() && Config::$dbEngine->checkConnection();
            } catch (Exception $e) {
                Debug::addException($e);
                return false;
            }
        }
    }
}
