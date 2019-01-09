<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Helpers;

use Alxarafe\Base\View;
use Alxarafe\Controllers\EditConfig;

/**
 * Class Dispatcher
 *
 * @package Alxarafe\Helpers
 */
class Dispatcher
{

    /**
     * Array that contains the paths to find the Controllers folder that
     * contains the controllers
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
        $this->searchDir[] = BASE_PATH;
        $this->searchDir[] = ALXARAFE_FOLDER;
        $this->nameSpaces[] = 'Alxarafe';
    }

    /**
     * Load the constants and the configuration file.
     * If the configuration file does not exist, it takes us to the form for its creation.
     */
    private function getConfiguration()
    {
        $this->defineConstants();
        // First set the display options to be able to show the possible warnings and errors.
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
        Utils::defineIfNotExists('BASE_PATH', __DIR__ . '/../../../..');
        Utils::defineIfNotExists('DEBUG', false);

        define('APP_URI', pathinfo(filter_input(INPUT_SERVER, 'SCRIPT_NAME'), PATHINFO_DIRNAME));

        define('SERVER_NAME', filter_input(INPUT_SERVER, 'SERVER_NAME'));
        define('APP_PROTOCOL', filter_input(INPUT_SERVER, 'REQUEST_SCHEME'));
        define('SITE_URL', APP_PROTOCOL . '://' . SERVER_NAME);
        define('BASE_URI', SITE_URL . APP_URI);

        /**
         * Must be defined in main index.php file
         */
        Utils::defineIfNotExists('VENDOR_FOLDER', BASE_PATH . '/vendor');
        Utils::defineIfNotExists('ALXARAFE_FOLDER', BASE_PATH . '/vendor/alxarafe/alxarafe/src/Core');
        Utils::defineIfNotExists('DEFAULT_TEMPLATES_FOLDER', BASE_PATH . '/vendor/alxarafe/alxarafe/templates');
        Utils::defineIfNotExists('VENDOR_URI', BASE_URI . '/vendor');
        Utils::defineIfNotExists('ALXARAFE_URI', BASE_URI . '/vendor/alxarafe/alxarafe/src/Core');
        Utils::defineIfNotExists('DEFAULT_TEMPLATES_URI', BASE_URI . '/vendor/alxarafe/alxarafe/templates');

        define('CONFIGURATION_PATH', BASE_PATH . '/config');
        define('DEFAULT_STRING_LENGTH', 50);
        define('DEFAULT_INTEGER_SIZE', 10);
    }

    /**
     * Try to locate the $call class in $path, and execute the $method.
     * Returns true if it locates the class and the method exists,
     * executing it.
     *
     * @param string $path
     * @param string $call
     * @param string $method
     * @return bool
     */
    public function processFolder(string $path, string $call, string $method): bool
    {
        $className = $call;
        foreach ($this->nameSpaces as $nameSpace) {
            $_className = $nameSpace . '\\Controllers\\' . $call;
            if (class_exists($_className)) {
                $className = $_className;
            }
        }
        $controllerPath = $path . '/' . $call . '.php';
        if (file_exists($controllerPath)) {
            require_once $controllerPath;
            if (method_exists($className, $method)) {
                (new $className())->{$method}();
                return true;
            }
        }
        return false;
    }

    /**
     * Walk the paths specified in $this->searchDir, trying to find the
     * controller and method to execute.
     * Returns true if the method is found, and executes it.
     *
     * @return bool
     */
    public function process()
    {
        foreach ($this->searchDir as $dir) {
            $path = $dir . '/Controllers';
            $call = $_GET['call'] ?? 'index';
            $method = $_GET['run'] ?? 'main';
            if ($this->processFolder($path, $call, $method)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Run the application.
     *
     * @throws \DebugBar\DebugBarException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function run()
    {
        if (!$this->process()) {
            if (Skin::$view == null) {
                $view = new View();
            }
        }
    }
}
