<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe;

use Alxarafe\Base\View;
use Alxarafe\Helpers\Config;
use Alxarafe\Helpers\Lang;
use Alxarafe\Helpers\Session;
use Alxarafe\Helpers\Skin;
use Alxarafe\Helpers\Utils;
use Alxarafe\Providers\Container;
use Alxarafe\Providers\Router;
use Kint\Kint;
use Symfony\Component\Yaml\Yaml;

/**
 * Class BootStrap
 *
 * @package Alxarafe
 */
class BootStrap
{
    /**
     * Fallback language.
     */
    const FALLBACK_LANG = 'en';

    /**
     * The base path where project is placed.
     *
     * @var string
     */
    protected $basePath;

    /**
     * True if it's in debug mode, otherwise false.
     *
     * @var bool
     */
    protected $isDebug;

    /**
     * The full route file path.
     *
     * @var string
     */
    protected $routeFile;

    /**
     * Route to manage available routes.
     *
     * @var Router
     */
    protected $router;

    /**
     * To manage PHP Sessions.
     *
     * @var Session
     */
    protected $session;

    /**
     * Default language to use.
     *
     * @var string
     */
    protected $defaultLang;

    /**
     * The translator class.
     *
     * @var Lang
     */
    protected $translator;

    /**
     * Manage connection and database queries.
     *
     * @var
     */
    protected $database;

    /**
     * The full config file path.
     *
     * @var string
     */
    protected $configFile;

    /**
     * The list of config value from file.
     *
     * @var array
     */
    protected $configData;

    /**
     * Manage the render.
     *
     * @var
     */
    protected $render;

    /**
     * Contains dependencies.
     *
     * @var Container
     */
    protected $container;

    /**
     * BootStrap constructor.
     *
     * @param string $basePath
     * @param bool   $debug
     */
    public function __construct($basePath = __DIR__ . '/..', $debug = false)
    {
        $this->basePath = $basePath;
        $this->configFile = $this->basePath . '/config/config.yaml';
        $this->isDebug = $debug;
        $this->session = new Session();
        $this->routeFile = $this->basePath . '/config/routes.yaml';
        $this->router = new Router($this->routeFile);
        $this->configData = $this->loadConfigurationFile();
        $this->loadConstants();
        $this->defaultLang = $this->configData['language'] ?? self::FALLBACK_LANG;
        $this->translator = new Lang($this->defaultLang, constant('ALXARAFE_FOLDER'));
        $this->database = null;
        $this->render = Skin::$view = new View();
        $this->container = new Container();
    }

    /**
     * Returns an array with the configuration defined in the configuration file.
     *
     * @return array
     */
    private function loadConfigurationFile(): array
    {
        if ($this->fileExists($this->configFile)) {
            $yaml = file_get_contents($this->configFile);
            if ($yaml) {
                return Yaml::parse($yaml);
            }
        }
        return $this->getDefaultConfig();
    }

    /**
     * @param $filename
     *
     * @return bool
     */
    private function fileExists($filename)
    {
        return (isset($filename) && file_exists($filename) && is_file($filename));
    }

    /**
     * Returns default configuration.
     *
     * @return array
     */
    private function getDefaultConfig()
    {
        $defaultData = [
            'dbEngineName' => 'PdoMySql',
            'dbPrefix' => '',
            'dbUser' => 'dbUser',
            'dbPass' => 'dbPass',
            'dbName' => 'dbName',
            'dbHost' => 'localhost',
            'dbPort' => '',
            'skin' => 'default',
            'language' => 'es_ES',
        ];



        return $defaultData;
    }

    /**
     *
     */
    private function loadConstants()
    {
        define('APP_URI', pathinfo(filter_input(INPUT_SERVER, 'SCRIPT_NAME'), PATHINFO_DIRNAME));

        define('SERVER_NAME', filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_ENCODED));
        define('APP_PROTOCOL', filter_input(INPUT_SERVER, 'REQUEST_SCHEME', FILTER_SANITIZE_ENCODED));
        define('SITE_URL', constant('APP_PROTOCOL') . '://' . constant('SERVER_NAME'));
        define('BASE_URI', constant('SITE_URL') . constant('APP_URI'));

        Utils::defineIfNotExists('ALXARAFE_FOLDER', constant('BASE_PATH') . '/src/Core');
        Utils::defineIfNotExists('CALL_CONTROLLER', 'call');
        Utils::defineIfNotExists('METHOD_CONTROLLER', 'method');
        Utils::defineIfNotExists('DEFAULT_CONTROLLER', ($this->fileExists($this->configFile) ? 'EditConfig' : 'CreateConfig'));
        Utils::defineIfNotExists('DEFAULT_METHOD', 'run');
    }

    /**
     * Initialize the class.
     */
    public function init()
    {
        $this->toConfig();
        $this->toContainer();
        $this->run();
    }

    /**
     * To set some values to Config (retro-compatibility)
     */
    private function toConfig()
    {
        new Config();
        Config::setDbEngine($this->database);
        Config::setGlobals([
            'language' => $this->defaultLang,
            'dbEngineName' => $this->configData['dbEngineName'],
            'dbPrefix' => $this->configData['dbPrefix'],
            'dbUser' => $this->configData['dbUser'],
            'dbPass' => $this->configData['dbPass'],
            'dbName' => $this->configData['dbName'],
            'dbHost' => $this->configData['dbHost'],
            'dbPort' => $this->configData['dbPort'],
        ]);
        Config::setLang($this->translator);
        Config::setSession($this->session);
        Config::connectToDatabase();
        Config::setDbEngine(Config::$dbEngine);
        $this->database = Config::$dbEngine;
    }

    /**
     * Put it to a container, to be accessible from any place.
     */
    private function toContainer()
    {
        $configFiles = [
            'config' => $this->configFile,
            'router' => $this->routeFile,
        ];
        $this->container->add('configFiles', $configFiles);
        $this->container->add('config', $this->configData);
        $this->container->add('session', $this->session);
        $this->container->add('router', $this->router);
        $this->container->add('defaultLang', $this->defaultLang);
        $this->container->add('translator', $this->translator);
        $this->container->add('database', $this->database);
        $this->container->add('render', $this->render);
    }

    /**
     *
     */
    public function run()
    {
        $call = filter_input(INPUT_GET, constant('CALL_CONTROLLER'), FILTER_SANITIZE_ENCODED);
        $call = !empty($call) ? $call : constant('DEFAULT_CONTROLLER');
        $method = filter_input(INPUT_GET, constant('METHOD_CONTROLLER'), FILTER_SANITIZE_ENCODED);
        $method = !empty($method) ? $method : constant('DEFAULT_METHOD');

        if ($this->router->hasRoute($call)) {
            $controllerName = $this->router->getRoute($call);
            if (method_exists($controllerName, $method)) {
                $controller = new $controllerName($this->container);

                Kint::dump($this->container);

                $controller->{$method}();
                return;
            } else {
                $msg = 'Method not available';
            }
        } else {
            $msg = 'Route not found';
        }
        echo $msg;
        return;
    }
}
