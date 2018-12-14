<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Helpers;

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
     * Contains the instance to the database engine (or null)
     * 
     * @var Engine|null
     */
    static $dbEngine;

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

    /*
      static $ctrl;
      static $ctrl;
      static $model;
      static $view;
      static $lastError;
     */

    /**
     * Returns the name of the configuration file. By default, create the config
     * folder and enter the config.yaml file inside it.
     * If you want to use another folder for the configuration, you will have to
     * define it in the constant CONFIGURATION_PATH before invoking this method,
     * this folder must exist.
     *
     * @return string|null
     */
    public static function getConfigurationFile()// : ?string - NetBeans only supports up to php7.0, for this you need php7.1
    {
        if (!defined('CONFIGURATION_PATH')) {
            define('CONFIGURATION_PATH', BASE_PATH . 'config/');
        }
        $filename = CONFIGURATION_PATH . 'config.yaml';
        if (file_exists($filename) || is_dir(CONFIGURATION_PATH) || mkdir(CONFIGURATION_PATH, 0777, true)) {
            return $filename;
        }
        return null;
    }

    /**
     * Load the configuration file and initialize the template engine and the database.
     */
    public static function loadConfig()
    {
        self::$global = [];
        if (self::loadConfigFile()) {
            Skin::setTemplatesEngine(self::getVar('templatesEngine') ?? 'twig');
            Skin::setTemplate(self::getVar('template') ?? 'default');
            Skin::setCommonTemplatesFolder(self::getVar('commonTemplatesFolder') ?? BASE_PATH . 'views/common/');
            Skin::setTemplatesFolder(self::getVar('templatesFolder') ?? BASE_PATH . 'views/templates/' . self::getVar('template'));
        }
        if (self::connectToDatabase() && self::$user == null) {
            self::$user = new Auth();
        }
    }

    /**
     * Read the variables stored in the configuration file
     *
     * @return bool
     */
    public static function loadConfigFile(): bool
    {
        $yaml = file_get_contents(self::getConfigurationFile());
        if ($yaml === false) {
            return false;
        }
        self::$global = YAML::parse($yaml);
        return true;
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
     */
    public static function connectToDatabase(): bool
    {
        if (self::$dbEngine == null) {
            $dbEngineName = self::$global['dbEngineName'] ?? 'PdoMySql';
            Debug::addMessage('SQL', "Using '$dbEngineName' engine.");

            $engine = '\\Alxarafe\\Database\\Engines\\' . $dbEngineName;
            try {
                Config::$dbEngine = new $engine([
                    'dbUser' => self::$global['dbUser'],
                    'dbPass' => self::$global['dbPass'],
                    'dbName' => self::$global['dbName'],
                    'dbHost' => self::$global['dbHost'],
                    'dbPort' => self::$global['dbPort'],
                ]);
            } catch (Exception $e) {
                Debug::addException($e);
            }

            if (!isset(self::$dbEngine)) {
                return false;
            }
            return self::$dbEngine->connect();
        }
        return true;
    }
}
