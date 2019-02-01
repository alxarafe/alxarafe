<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Helpers;

use Alxarafe\Base\View;
use Alxarafe\Controllers\CreateConfig;
use Alxarafe\Models\Page;
use Exception;
use ReflectionClass;
use Symfony\Component\Finder\Finder;

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

    /**
     * Dispatcher constructor.
     */
    public function __construct()
    {
        $this->getConfiguration();
        Debug::startTimer('full-execution', 'Complete execution');
        // Search controllers in BASE_PATH/Controllers and ALXARAFE_FOLDER/Controllers
        $this->searchDir = ['Alxarafe' => constant('ALXARAFE_FOLDER')];
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
        define('DEFAULT_METHOD', 'run');

        // Use cache on Core
        define('CORE_CACHE_ENABLED', true);

        // Default number of rows per page.
        define('DEFAULT_ROWS_PER_PAGE', 25);

        // Carry Return (retorno de carro) & Line Feed (salto de línea).
        define('CRLF', "\n\t");
    }

    /**
     * Run the application.
     *
     * @return void
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
        $this->regenerateData();
        foreach ($this->searchDir as $namespace => $dir) {
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
    public function processFolder(string $path, string $call, string $method = null): bool
    {
        if ($method === null) {
            $method = constant('DEFAULT_METHOD');
        }
        if (empty(Config::loadConfigurationFile()) || !Config::connectToDataBase()) {
            if ($call !== 'CreateConfig' || $method !== 'main') {
                Config::setError('Database Connection error...');
                (new CreateConfig())->index();
                return true;
            }
        }
        $className = $call;
        foreach ($this->searchDir as $nameSpace => $dirPath) {
            $_className = '\\' . $nameSpace . '\\Controllers\\' . $call;
            if (class_exists($_className)) {
                $className = $_className;
            }
        }
        $controllerPath = $path . '/' . $call . '.php';
        if (file_exists($controllerPath) && is_file($controllerPath) && method_exists($className, $method)) {
            $theClass = new $className();
            Debug::addMessage('messages', 'Executing: ' . $call . '->index()');
            $shortName = (new ReflectionClass($theClass))->getShortName();

            Debug::startTimer($shortName . '->index()', $shortName . '->index()');
            $theClass->index();
            Debug::stopTimer($shortName . '->index()');

            Debug::addMessage('messages', 'Executing: ' . $call . '->' . $method . '()');
            Debug::startTimer($shortName, $shortName . '->' . $method . '()');
            $theClass->{$method}();
            Debug::stopTimer($shortName . '->' . $method . '()');
            return true;
        }
        return false;
    }

    /**
     * Regenerate some needed data.
     *
     * TODO: Some parts must be moved to another parts on a near future.
     *
     * @return void
     */
    private function regenerateData(): void
    {
        if (constant('DEBUG') === true) {
//            Debug::addMessage('messages', 'This calls must be in another place a near future.');
            $this->instantiateModels();
            $this->checkPageControllers();
        }
    }

    /**
     * Instantiate all available models
     *
     * TODO: This must be executed only when update/upgrade the core. At this moment is forced if DEBUG is enabled.
     *
     * @return void
     */
    private function instantiateModels(): void
    {
        // Start DB transaction
        Config::$dbEngine->beginTransaction();

        foreach ($this->searchDir as $namespace => $baseDir) {
            $models = Finder::create()
                ->files()
                ->name('*.php')
                ->in($dir = $baseDir . '/Models');
            foreach ($models as $modelFile) {
                $class = str_replace([$dir, '/', '\\', '.php'], ['', '', '', ''], $modelFile);
//                Debug::addMessage('messages', 'Instantiate model: ' . $class);
                $class = '\\' . $namespace . '\\Models\\' . $class;
                new $class();
            }
        }

        // End DB transaction
        Config::$dbEngine->commit();
    }

    /**
     * Check all clases that extends from PageController, an store it to pages table.
     * We needed to generate the user menu.
     *
     * TODO: This must be checked only when update/upgrade the core.
     * WARNING: At this moment are generating 3 extra SQL queries per table.
     *
     * @return void
     */
    private function checkPageControllers(): void
    {
        // Start DB transaction
        Config::$dbEngine->beginTransaction();

        foreach ($this->searchDir as $namespace => $baseDir) {
            $controllers = Finder::create()
                ->files()
                ->name('*.php')
                ->in($dir = $baseDir . DIRECTORY_SEPARATOR . 'Controllers');
            foreach ($controllers as $controllerFile) {
                $className = str_replace([$dir . DIRECTORY_SEPARATOR, '.php'], ['', ''], $controllerFile);
                $class = '\\' . $namespace . '\\Controllers\\' . $className;
//                Debug::addMessage('messages', 'Instantiation of class ' . $className . ' extending PageController');
                $newClass = new $class();
                $parents = class_parents($newClass);
//                if (in_array('Xfs\Base\XfsController', $parents)) {
//                    Debug::addMessage('messages', 'Class ' . $className . ' also extends from XfsController');
//                }
                if (in_array('Alxarafe\Base\PageController', $parents)) {
                    $page = new Page();
                    if (!$page->getBy('controller', $className)) {
                        $page = new Page();
                    }
                    $page->controller = $className;
                    $page->title = $newClass->title;
                    $page->description = $newClass->description;
                    $page->menu = $newClass->menu;
                    $page->icon = $newClass->icon;
                    $page->plugin = $namespace;
                    $page->active = 1;
                    $page->updated_date = date('Y-m-d H:i:s');

                    $page->save();
//                    $msgSuccess = 'Page ' . $className . ' data added or updated to table';
//                    $msgError = 'Page ' . $className . ' can be saved to table <pre>' . var_export($page, true) . '</pre>';
//                    Debug::addMessage('messages', ($page->save() ? $msgSuccess : $msgError));
                }
            }
        }

        // End DB transaction
        Config::$dbEngine->commit();
    }
}
