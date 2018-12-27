<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Helpers;

use Alxarafe\Helpers\Config;
use Alxarafe\Helpers\Debug;
use Alxarafe\Base\View;
use Alxarafe\Controllers\EditConfig;

class Dispatcher
{

    public function __construct()
    {
        $this->getConfiguration();
        if (Config::$user != null) {
            $user = Config::$user->getUser();
            if ($user == null) {
                if (isset($_POST['username'])) {
                    Config::$user->setUser($_POST['username'], $_POST['password']);
                }
                $user = isset(Config::$user) && Config::$user->getUser();
                if ($user == null) {
                    Config::$user->login();
                    return;
                }
            }
        }
        if (isset($_GET['logout'])) {
            unset($_GET['logout']);
            Config::$user->logout();
            // TODO: Ver si hay mejor forma de hacerlo
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
        $call = $_POST['call'] ?? 'index';
    }

    private function getConfiguration()
    {
        $this->defineConstants();
        Config::loadViewsConfig();
        $configFile = Config::getConfigFileName();
        if (file_exists($configFile)) {
            Config::loadDbConfig();
        }
        /* else {

          /*
          //echo "<p>Creating <strong>$configFile</strong>...</p>";
          /**
         * These are the default values.
         * It is not necessary to define them, if we are going to use these.
         * /
          Config::setVar('templateEngine', 'twig');
          Config::setVar('templatesFolder', 'default');
          Config::setVar('commonTemplatesFolder', BASE_PATH . '/views/common');

          /**
         * Database configuration parameters
         * /
          Config::setVar('dbEngine', 'PdoMySql');
          Config::setVar('dbUser', 'root');
          Config::setVar('dbPass', '');
          Config::setVar('dbName', 'alxarafe');
          Config::setVar('dbHost', '');
          Config::setVar('dbPort', '');

          Config::saveConfigFile();

          (new EditConfig())->run();
          return;
          }
         *
         */

        /*
          echo "<p>The configuration of the <strong>$configFile</strong> file has been loaded...</p>";
          echo '<pre>' . file_get_contents($configFile) . '</pre>';
          echo '<p>This file contains the configuration of the database.</p>';
          echo '<p>If the file is not correct, delete it and it will be created again.</p>';
         */
    }

    /**
     * Define the constants of the application
     */
    public function defineConstants()
    {
        /**
         * It is recommended to define BASE_PATH as the first line of the
         * index.php file of the application.
         *
         * define('BASE_PATH', __DIR__);
         */
        if (!defined('BASE_PATH')) {
            define('BASE_PATH', __DIR__ . '/../../../..');
        }

        if (!defined('DEBUG')) {
            define('DEBUG', false);
        }

        define('APP_URI', pathinfo(filter_input(INPUT_SERVER, 'SCRIPT_NAME'), PATHINFO_DIRNAME));

        define('SERVER_NAME', filter_input(INPUT_SERVER, 'SERVER_NAME'));
        define('APP_PROTOCOL', filter_input(INPUT_SERVER, 'REQUEST_SCHEME'));
        define('SITE_URL', APP_PROTOCOL . '://' . SERVER_NAME);
        define('BASE_URI', SITE_URL . APP_URI);

        /**
         * Must be defined in main index.php file
         */
        if (!defined('VENDOR_FOLDER')) {
            define('VENDOR_FOLDER', BASE_URI . '/vendor');
            define('ALXARAFE_FOLDER', BASE_URI . '/vendor/alxarafe');
            define('DEFAULT_TEMPLATES_FOLDER', BASE_URI . '/vendor/alxarafe/alxarafe/templates');
        }

        define('CONFIGURATION_PATH', BASE_PATH . '/config');
        define('DEFAULT_STRING_LENGTH', 50);
        define('DEFAULT_INTEGER_SIZE', 10);
        define('RANDOM_PATH_NAME', '/ADFASDFASD');
    }

    function process()
    {
        // Planificador por defecto
    }

    function run()
    {
        $this->process();
        $view = new View();
        $view->run($vars);
    }
}
