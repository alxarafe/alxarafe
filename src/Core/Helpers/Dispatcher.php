<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Helpers;

use Alxarafe\Helpers\Config;
use Alxarafe\Base\View;
use Alxarafe\Controllers\EditConfig;

class Dispatcher
{

    public $searchDir;

    public function __construct()
    {
        $this->getConfiguration();

        // Search controllers in BASE_PATH/Controllers and ALXARAFE_FOLDER/Controllers
        $this->searchDir = [BASE_PATH, BASE_PATH . '/' . ALXARAFE_FOLDER];
    }

    private function getConfiguration()
    {
        $this->defineConstants();
        Config::loadViewsConfig();
        $configFile = Config::getConfigFileName();
        if (file_exists($configFile)) {
            Config::loadConfig();
        } else {
            Config::setError("Creating '$configFile' file...");
            (new EditConfig())->run();
            die;
        }
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
        }
        if (!defined('ALXARAFE_FOLDER')) {
            define('ALXARAFE_FOLDER', BASE_URI . '/vendor/alxarafe');
        }
        if (!defined('DEFAULT_TEMPLATES_FOLDER')) {
            define('DEFAULT_TEMPLATES_FOLDER', BASE_PATH . '/vendor/alxarafe/alxarafe/templates');
        }

        define('CONFIGURATION_PATH', BASE_PATH . '/config');
        define('DEFAULT_STRING_LENGTH', 50);
        define('DEFAULT_INTEGER_SIZE', 10);
    }

    function processFolder($path, $call, $method)
    {
        $_className = 'Alxarafe\\Controllers\\' . $call;
        if (class_exists($_className)) {
            $className = $_className;
        } else {
            $className = $call;
        }
        $controllerPath = $path . '/' . $call . '.php';
        if (file_exists($controllerPath)) {
            require_once $controllerPath;
            if (method_exists($className, $method)) {
                $controller = new $className();
                return $controller->{$method}();
            }
        }
    }

    function process()
    {
        foreach ($this->searchDir as $dir) {
            $path = $dir . '/Controllers';
            $call = $_GET['call'] ?? 'index';
            $method = $_GET['run'] ?? 'run';
            if ($this->processFolder($path, $call, $method)) {
                return true;
            }
        }
        return false;
    }

    function run()
    {
        if (!$this->process()) {
            $view = new View();
            $view->run();
        }
    }
}
