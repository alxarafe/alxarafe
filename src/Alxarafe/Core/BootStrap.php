<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core;

use Alxarafe\Core\Base\CacheCore;
use Alxarafe\Core\Helpers\FormatUtils;
use Alxarafe\Core\Helpers\Session;
use Alxarafe\Core\Helpers\Utils\ClassUtils;
use Alxarafe\Core\Providers\Config;
use Alxarafe\Core\Providers\Container;
use Alxarafe\Core\Providers\Database;
use Alxarafe\Core\Providers\DebugTool;
use Alxarafe\Core\Providers\Logger;
use Alxarafe\Core\Providers\ModuleManager;
use Alxarafe\Core\Providers\RegionalInfo;
use Alxarafe\Core\Providers\Router;
use Alxarafe\Core\Providers\TemplateRender;
use Alxarafe\Core\Providers\Translator;
use Kint\Kint;
use Modules\xapi\Core\AppApi;
use Symfony\Component\Cache\Adapter\PhpArrayAdapter;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BootStrap
 *
 * @package Alxarafe\Core
 */
class BootStrap
{
    /**
     * Fallback language.
     */
    public const FALLBACK_LANG = 'en';

    /**
     * Return current Unix timestamp with microseconds.
     *
     * @var float
     */
    protected static $startTimer;

    /**
     * Hold the classes on instance.
     *
     * @var BootStrap
     */
    private static $instance;

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
     * @var Database
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
     * @var PhpArrayAdapter
     */
    protected $cacheEngine;

    /**
     * The regional information for this app.
     *
     * @var RegionalInfo
     */
    protected $regionalInfo;

    /**
     * BootStrap constructor.
     *
     * @param string $basePath
     * @param bool   $debug
     */
    public function __construct($basePath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..', $debug = false)
    {
        if (!isset(self::$instance)) {
            self::$instance = $this;
            self::$startTimer = microtime(true);
            $this->basePath = realpath($basePath);
            $this->isDebug = $debug;
            Kint::$enabled_mode = $this->isDebug;
            $shortName = ClassUtils::getShortName($this, static::class);

            $this->configManager = Config::getInstance();
            $this->configManager->loadConstants();
            $this->debugTool = DebugTool::getInstance();
            $this->debugTool->startTimer($shortName, $shortName . ' BootStrap Constructor');

            $this->regionalInfo = RegionalInfo::getInstance();
            $this->log = Logger::getInstance();
            $this->container = Container::getInstance();

            $this->request = Request::createFromGlobals();
            $this->response = new Response();

            $this->session = Session::getInstance();
            $this->router = Router::getInstance();
            $this->translator = Translator::getInstance();
            $this->defaultLang = $this->translator->getConfig()['language'];
            $this->cacheEngine = CacheCore::getInstance()->getEngine();
            $this->configData = $this->configManager->getConfigContent();
            if (!empty($this->configData)) {
                $this->database = Database::getInstance();
                $this->database->connectToDatabase();
            }
            $this->renderer = TemplateRender::getInstance();

            FormatUtils::loadConfig();
            $this->debugTool->stopTimer($shortName);
        }
    }

    /**
     * Returns this instance.
     *
     * @return self
     */
    public static function getInstance(): self
    {
        return self::$instance;
    }

    /**
     * Return start time with microtime.
     *
     * @return float
     */
    public static function getStartTime(): float
    {
        return self::$startTimer;
    }

    /**
     * Initialize the class.
     */
    public function init(): void
    {
        $this->toContainer();
        // Execute loadModules only if database is working
        if (isset($this->database) && null !== $this->database->getDbEngine()) {
            ModuleManager::getInstance()::initializeModules();
        }
        $task = $this->request->query->get('task');
        switch ($task) {
            case 'cron':
                break;
            case 'api':
                $this->api();
                break;
            default:
                $this->run();
                break;
        }
    }

    /**
     * Put it to a container, to be accessible from any place.
     */
    private function toContainer(): void
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
    public function run(): void
    {
        $call = $this->request->query->get(constant('CALL_CONTROLLER'));
        $call = !empty($call) ? $call : constant('DEFAULT_CONTROLLER');
        $method = $this->request->query->get(constant('METHOD_CONTROLLER'));
        $method = !empty($method) ? $method : constant('DEFAULT_METHOD');

        if ($call !== 'CreateConfig' && !$this->configManager->configFileExists()) {
            $time = time() - 3600;
            setcookie('user', '', $time, constant('APP_URI'), $_SERVER['HTTP_HOST']);
            setcookie('logkey', '', $time, constant('APP_URI'), $_SERVER['HTTP_HOST']);
            (new RedirectResponse(baseUrl('index.php?' . constant('CALL_CONTROLLER') . '=CreateConfig')))->send();
            return;
        }

        $controller = null;
        $msg = $this->translator->trans('route-not-found');
        $this->response->setStatusCode(Response::HTTP_NOT_FOUND);
        if ($this->router->hasRoute($call)) {
            $controllerName = $this->router->getRoute($call);
            $msg = $this->translator->trans('method-not-available');
            $this->response->setStatusCode(Response::HTTP_METHOD_NOT_ALLOWED);
            if (method_exists($controllerName, $method . 'Method')) {
                $controller = new $controllerName();
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

    /**
     * Call to API module, if exists.
     *
     * @return bool
     */
    public function api()
    {
        $apiCodePath = $this->basePath . '/src/Modules/xapi/Core/AppApi.php';
        if (!file_exists($apiCodePath)) {
            die(json_encode(['error' => 'Please, install xapi module']));
        }
        include $apiCodePath;
        $api = new AppApi([
            'basePath' => $this->basePath,
            'router' => $this->router,
            'database' => $this->database,
            'configData' => $this->configData,
            'request' => $this->request,
            'response' => $this->response,
            'log' => $this->log,
            'regionalInfo' => $this->regionalInfo,
        ]);
        $api->run();
        die($api->render());
    }
}
