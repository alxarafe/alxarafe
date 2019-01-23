<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Helpers;

use Alxarafe\Base\View;
use Alxarafe\Controllers\CreateConfig;
use Exception;

/**
 * Class Dispatcher
 *
 * @package Alxarafe\Helpers
 */
class Dispatcher
{

    /**
     * Array that contains the paths to find the Controllers folder that contains the controllers
     *
     * @var array
     */
    public $searchDir;
    public $nameSpaces;

    /**
     * Dispatcher constructor.
     */
    public function __construct()
    {
        $this->getConfiguration();

        // Search controllers in BASE_PATH/Controllers and ALXARAFE_FOLDER/Controllers
        $this->searchDir[] = constant('BASE_PATH');
        $this->searchDir[] = constant('ALXARAFE_FOLDER');
        $this->nameSpaces[] = 'Alxarafe';
    }

    /**
     * Load the constants and the configuration file.
     * If the configuration file does not exist, it takes us to the form for its creation.
     */
    private function getConfiguration(): void
    {
        $this->defineConstants();
        // First set the display options to be able to show the possible warnings and errors.
        Config::loadViewsConfig();
        $configFile = Config::getConfigFileName();
        if (!file_exists($configFile)) {
            $msg = "Creating '$configFile' file...";
            Config::setError($msg);
            new CreateConfig();
            $e = new Exception($msg);
            Debug::addException($e);
        }
        Config::loadConfig();
    }

    /**
     * Define the constants of the application
     */
    public function defineConstants(): void
    {
        /**
         * It is recommended to define BASE_PATH as the first line of the index.php file of the application.
         *
         * define('BASE_PATH', __DIR__);
         */
        Utils::defineIfNotExists('BASE_PATH', __DIR__ . '/../../../..');
        Utils::defineIfNotExists('LANG', 'en_EN');
        Utils::defineIfNotExists('DEBUG', false);

        define('APP_URI', pathinfo(filter_input(INPUT_SERVER, 'SCRIPT_NAME'), PATHINFO_DIRNAME));

        define('SERVER_NAME', filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_ENCODED));
        define('APP_PROTOCOL', filter_input(INPUT_SERVER, 'REQUEST_SCHEME', FILTER_SANITIZE_ENCODED));
        define('SITE_URL', constant('APP_PROTOCOL') . '://' . constant('SERVER_NAME'));
        define('BASE_URI', constant('SITE_URL') . constant('APP_URI'));

        /**
         * Must be defined in main index.php file
         */
        Utils::defineIfNotExists('VENDOR_FOLDER', constant('BASE_PATH') . '/vendor');
        Utils::defineIfNotExists('ALXARAFE_FOLDER', constant('BASE_PATH') . '/vendor/alxarafe/alxarafe/src/Core');
        Utils::defineIfNotExists('DEFAULT_TEMPLATES_FOLDER', constant('BASE_PATH') . '/vendor/alxarafe/alxarafe/templates');
        Utils::defineIfNotExists('VENDOR_URI', constant('BASE_URI') . '/vendor');
        Utils::defineIfNotExists('ALXARAFE_URI', constant('BASE_URI') . '/vendor/alxarafe/alxarafe/src/Core');
        Utils::defineIfNotExists('DEFAULT_TEMPLATES_URI', constant('BASE_URI') . '/vendor/alxarafe/alxarafe/templates');

        define('CONFIGURATION_PATH', constant('BASE_PATH') . '/config');
        define('DEFAULT_STRING_LENGTH', 50);
        define('DEFAULT_INTEGER_SIZE', 10);

        define('CALL_CONTROLLER', 'call');
        define('METHOD_CONTROLLER', 'method');
        define('DEFAULT_CONTROLLER', (Config::configFileExists() ? 'EditConfig' : 'CreateConfig'));
        define('DEFAULT_METHOD', 'index');
    }

    /**
     * Run the application.
     */
    public function run(): void
    {
        if (!$this->process()) {
            if (Skin::$view == null) {
                Skin::$view = new View();
            }
        }

        if (Skin::$view !== null) {
            Skin::$view->render();
        }
    }

    /**
     * Walk the paths specified in $this->searchDir, trying to find the controller and method to execute.
     * Returns true if the method is found, and executes it.
     *
     * @return bool
     */
    public function process(): bool
    {
        foreach ($this->searchDir as $dir) {
            $path = $dir . '/Controllers';
            $call = filter_input(INPUT_GET, constant('CALL_CONTROLLER'), FILTER_SANITIZE_ENCODED);
            $call = !empty($call) ? $call : constant('DEFAULT_CONTROLLER');
            $method = filter_input(INPUT_GET, constant('METHOD_CONTROLLER'), FILTER_SANITIZE_ENCODED);
            $method = !empty($method) ? $method : constant('DEFAULT_METHOD');
            if ($this->processFolder($path, $call, $method)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Try to locate the $call class in $path, and execute the $method.
     * Returns true if it locates the class and the method exists, executing it.
     *
     * @param string $path
     * @param string $call
     * @param string $method
     *
     * @return bool
     */
    public function processFolder(string $path, string $call, string $method = 'index'): bool
    {
        $className = $call;
        foreach ($this->nameSpaces as $nameSpace) {
            $_className = $nameSpace . '\\Controllers\\' . $call;
            if (class_exists($_className)) {
                $className = $_className;
            }
        }
        $controllerPath = $path . '/' . $call . '.php';
        if (file_exists($controllerPath) && is_file($controllerPath)) {
            require_once $controllerPath;
            if (method_exists($className, $method)) {
                (new $className())->{$method}();
                return true;
            }
        }
        return false;
    }
}
