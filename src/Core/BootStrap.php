<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe;

use Alxarafe\Helpers\Config;
use Alxarafe\Helpers\Lang;
use Alxarafe\Helpers\Session;
use Alxarafe\Providers\ConfigurationManager;
use Alxarafe\Providers\Container;
use Alxarafe\Providers\Database;
use Alxarafe\Providers\Router;
use Alxarafe\Providers\TemplateRender;
use Kint\Kint;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
     * @var ConfigurationManager
     */
    protected $configManager;

    /**
     * Request from client.
     *
     * @var Request
     */
    protected $request;

    /**
     * Response to client.
     *
     * @var Response
     */
    protected $response;

    /**
     * BootStrap constructor.
     *
     * @param string $basePath
     * @param bool   $debug
     */
    public function __construct($basePath = __DIR__ . '/..', $debug = false)
    {
        $this->basePath = $basePath;
        $this->isDebug = $debug;

        $this->container = new Container();

        $this->request = Request::createFromGlobals();
        $this->response = new Response();

        $this->configManager = new ConfigurationManager($this->basePath . '/config');

        $this->configManager->setConfigFile('config.yaml');
        $this->configFile = $this->configManager->getConfigFile();

        /*
          $this->configManager->setRouteFile('routes.yaml');
          $this->routeFile = $this->configManager->getRouteFile();

          $this->session = new Session();
          $this->router = new Router($this->routeFile);
         */
        $this->session = new Session();

        $this->router = Router::getInstance();

        $this->configData = $this->configManager->getConfigContent();
        if (empty($this->configData)) {
            $this->configData = $this->getDefaultConfig();
        }

        $this->configManager->loadConstants();
        $this->defaultLang = $this->configData['language'] ?? self::FALLBACK_LANG;
        $this->translator = new Lang($this->defaultLang, constant('ALXARAFE_FOLDER'));
        $this->database = new Database($this->configData['database']);
        $this->render = new TemplateRender($this->container);
    }

    /**
     * Returns default configuration.
     *
     * @return array
     */
    private function getDefaultConfig()
    {
        $defaultData = [
            'database' => [
                'dbEngineName' => 'PdoMySql',
                'dbPrefix' => '',
                'dbUser' => 'dbUser',
                'dbPass' => 'dbPass',
                'dbName' => 'dbName',
                'dbHost' => 'localhost',
                'dbPort' => '',
            ],
            'skin' => 'default',
            'language' => 'es_ES',
        ];
        $this->configManager->setConfigContent($defaultData);
        return $defaultData;
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
            'dbEngineName' => $this->configData['database']['dbEngineName'],
            'dbPrefix' => $this->configData['database']['dbPrefix'],
            'dbUser' => $this->configData['database']['dbUser'],
            'dbPass' => $this->configData['database']['dbPass'],
            'dbName' => $this->configData['database']['dbName'],
            'dbHost' => $this->configData['database']['dbHost'],
            'dbPort' => $this->configData['database']['dbPort'],
        ]);
        Config::setLang($this->translator);
        Config::setSession($this->session);
        Config::setDbEngine(Config::$dbEngine);
        //Config::connectToDatabase();
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
        $this->container->add('request', $this->request);
        $this->container->add('response', $this->response);
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

        $controller = null;
        $msg = $this->translator->trans('route-not-found');
        $this->response->setStatusCode(Response::HTTP_NOT_FOUND);
        if ($this->router->hasRoute($call)) {
            $controllerName = $this->router->getRoute($call);
            $msg = $this->translator->trans('method-not-available');
            $this->response->setStatusCode(Response::HTTP_METHOD_NOT_ALLOWED);
            if (method_exists($controllerName, $method)) {
                $controller = new $controllerName($this->container);
                $reply = $controller->{$method}();
                $this->response->setStatusCode(Response::HTTP_OK);
            }
        }

        if ($controller === null) {
            $this->render->setTemplate('error');
            $vars = [
                'ctrl' => $controller,
                'title' => $this->translator->trans('error'),
                'msg' => $msg,
            ];
            $reply = $this->render->render($vars);
        }

        $this->response->setContent($reply);
        $this->response->send();
    }
}
