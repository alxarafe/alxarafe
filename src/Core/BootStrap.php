<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe;

use Alxarafe\Base\CacheCore;
use Alxarafe\Helpers\Session;
use Alxarafe\Providers\Config;
use Alxarafe\Providers\Container;
use Alxarafe\Providers\Database;
use Alxarafe\Providers\DebugTool;
use Alxarafe\Providers\Logger;
use Alxarafe\Providers\Router;
use Alxarafe\Providers\TemplateRender;
use Alxarafe\Providers\Translator;
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
     * The translator manager.
     *
     * @var Translator
     */
    protected $translator;

    /**
     * Manage connection and database queries.
     *
     * @var
     */
    protected $database;

    /**
     * The list of config value from file.
     *
     * @var array
     */
    protected $configData;

    /**
     * Manage the renderer.
     *
     * @var TemplateRender
     */
    protected $renderer;

    /**
     * Contains dependencies.
     *
     * @var Container
     */
    protected $container;

    /**
     * @var Config
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
     * The logger.
     *
     * @var Logger
     */
    protected $log;

    /**
     * The debug tool used.
     *
     * @var DebugTool
     */
    protected $debugTool;

    /**
     * The caché core engine adapter.
     *
     * @var \Symfony\Component\Cache\Adapter\PhpArrayAdapter
     */
    protected $cacheEngine;

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

        $this->log = Logger::getInstance();
        $this->container = Container::getInstance();

        $this->request = Request::createFromGlobals();
        $this->response = new Response();

        $this->configManager = Config::getInstance();
        $this->configManager->loadConstants();
        $this->configData = $this->configManager->getConfigContent();
        if (empty($this->configData)) {
            $this->configData = $this->getDefaultConfig();
        }

        $this->session = Session::getInstance();
        $this->router = Router::getInstance();
        $this->defaultLang = $this->configData['language'] ?? self::FALLBACK_LANG;
        $this->debugTool = DebugTool::getInstance();
        $this->translator = Translator::getInstance();
        $this->cacheEngine = CacheCore::getInstance()->getEngine();
        $this->database = Database::getInstance();
        $this->renderer = TemplateRender::getInstance();
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
        return $defaultData;
    }

    /**
     * Initialize the class.
     */
    public function init()
    {
        $this->toContainer();
        $this->run();
    }

    /**
     * Put it to a container, to be accessible from any place.
     */
    private function toContainer()
    {
        $configFiles = [
            'config' => $this->configManager->getFilePath(),
            'router' => $this->router->getFilePath(),
        ];
        $this->container::add('configFiles', $configFiles);
        $this->container::add('config', $this->configData);
        $this->container::add('defaultLang', $this->defaultLang);
        $this->container::add('request', $this->request);
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
            if (method_exists($controllerName, $method . 'Method')) {
                $controller = new $controllerName();
                $this->response = null;
                $this->response = $controller->runMethod($method);
                if (!$this->response instanceof Response) {
                    $this->response = new Response();
                    // This must be removed, only for now to complete
                    $reply = $this->translator->trans('not-response-from-controller') . ' ' . $controllerName . '->' . $method;
                    $this->response->setStatusCode(Response::HTTP_GONE);
                    $this->response->setContent($reply);
                }
            }
        }

        if ($controller === null) {
            $this->renderer->setTemplate('error');
            $vars = [
                'ctrl' => $controller,
                'title' => $this->translator->trans('error'),
                'msg' => $msg,
            ];
            $reply = $this->renderer->render($vars);
            $this->response->setContent($reply);
        }
        $this->response->send();
    }
}
