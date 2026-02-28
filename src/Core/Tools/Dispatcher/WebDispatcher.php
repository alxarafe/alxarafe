<?php

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace Alxarafe\Tools\Dispatcher;

use Alxarafe\Base\Config;
use Alxarafe\Base\Controller\ViewController;
use Alxarafe\Lib\Functions;
use Alxarafe\Lib\Routes;
use Alxarafe\Tools\Debug;
use CoreModules\Admin\Controller\ErrorController;
use DebugBar\DebugBarException;
use Alxarafe\Lib\Auth;

class WebDispatcher extends Dispatcher
{
    /**
     * Entry point for web requests. Automatically detects the route or uses GET parameters.
     *
     * @param string $defaultModule
     * @param string $defaultController
     * @param string $defaultAction
     * @return bool
     */
    public static function dispatch(
        string $defaultModule = 'Chascarrillo',
        string $defaultController = 'Blog',
        string $defaultAction = 'index'
    ): bool {
        try {
            // Initial path checks
            if (!defined('BASE_PATH')) {
                define('BASE_PATH', dirname($_SERVER['SCRIPT_FILENAME'] ?? __FILE__));
            }
            if (!defined('APP_PATH')) {
                $appPath = realpath(BASE_PATH . '/..');
                if (!$appPath) {
                    $appPath = dirname(BASE_PATH);
                }
                define('APP_PATH', $appPath);
            }

            if (!defined('ALX_PATH')) {
                // If src exists in APP_PATH, it means framework and app are in same root
                if (is_dir(constant('APP_PATH') . '/src/Core')) {
                    define('ALX_PATH', constant('APP_PATH'));
                } else {
                    // Try to guess from vendor or parent
                    $alxPath = realpath(constant('APP_PATH') . '/vendor/alxarafe/alxarafe');
                    define('ALX_PATH', $alxPath ?: dirname(constant('APP_PATH')));
                }
            }

            // Asset auto-publication check
            if (!is_dir(BASE_PATH . '/themes') || !is_dir(BASE_PATH . '/css')) {
                if (class_exists(\Alxarafe\Scripts\ComposerScripts::class)) {
                    $io = new class {
                        public function write($msg)
                        {
                            error_log("[AssetAutoPublish] " . $msg);
                        }
                        public function getIO()
                        {
                            return $this;
                        }
                    };
                    $event = new class($io) {
                        private $io;
                        public function __construct($io)
                        {
                            $this->io = $io;
                        }
                        public function getIO()
                        {
                            return $this->io;
                        }
                    };
                    \Alxarafe\Scripts\ComposerScripts::postUpdate($event);
                }
            }

            // Load routes
            $routesPath = constant('APP_PATH') . '/routes.php';
            $configRoutesPath = constant('APP_PATH') . '/config/routes.php';
            if (file_exists($configRoutesPath)) {
                require_once $configRoutesPath;
            } elseif (file_exists($routesPath)) {
                require_once $routesPath;
            }

            if (php_sapi_name() === 'cli') {
                $argv = $_SERVER['argv'] ?? [];
                $module = $argv[1] ?? $defaultModule;
                $controller = $argv[2] ?? $defaultController;
                $method = $argv[3] ?? $defaultAction;
            } else {
                // Try Router first if no module is explicitly provided
                $match = !isset($_GET['module']) ? \Alxarafe\Lib\Router::match($_SERVER['REQUEST_URI'] ?? '') : null;
                if ($match) {
                    $module = $match['module'];
                    $controller = $match['controller'];
                    $method = $match['action'];
                    // Merge params into $_GET for transparency
                    $_GET = array_merge($_GET, $match['params']);
                    $_GET['module'] = $module;
                    $_GET['controller'] = $controller;
                    $_GET['action'] = $method;
                    $_GET['route_name'] = $match['name'];
                } else {
                    $module = $_GET['module'] ?? $defaultModule;
                    $controller = $_GET['controller'] ?? $defaultController;
                    $method = $_GET['action'] ?? $_GET['method'] ?? $defaultAction;
                }
            }

            return static::run($module, $controller, $method);
        } catch (\Throwable $e) {
            // Anti-loop guard: if we're already heading to ErrorController, render raw HTML
            $isAlreadyError = (($module ?? '') === 'Admin' && ($controller ?? '') === 'Error');

            if (!$isAlreadyError && class_exists(ErrorController::class) && !headers_sent()) {
                $trace = $e->getTraceAsString();
                $url = ErrorController::url(true, false) . '&message=' . urlencode($e->getMessage()) . '&trace=' . urlencode($trace);
                \Alxarafe\Lib\Functions::httpRedirect($url);
            }

            // Fallback: render error directly to break any possible loop
            http_response_code(500);
            echo "<!DOCTYPE html><html><head><meta charset='utf-8'><title>Application Error</title>";
            echo "<style>body{font-family:system-ui,sans-serif;max-width:800px;margin:40px auto;padding:0 20px;background:#1a1a2e;color:#e0e0e0}";
            echo "h1{color:#e94560}pre{background:#16213e;padding:16px;border-radius:8px;overflow-x:auto;border:1px solid #0f3460;font-size:13px}</style></head>";
            echo "<body><h1>Application Error</h1>";
            echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
            echo "<h2>Stack Trace</h2>";
            echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
            echo "</body></html>";
            exit;
        }
    }

    /**
     * Run the controller for the indicated module, if it exists.
     * Returns true if it can be executed.
     *
     * @param string $module
     * @param string $controller
     * @param string $method
     *
     * @return bool
     * @throws DebugBarException
     */
    public static function run(string $module, string $controller, string $method): bool
    {
        Debug::initialize();

        $routes = Routes::getAllRoutes();
        $endpoint = $routes['Controller'][$module][$controller] ?? null;
        if ($endpoint === null) {
            static::dieWithMessage(\Alxarafe\Lib\Trans::_('dispatcher_module_controller_not_found', ['module' => $module, 'controller' => $controller]));
        }

        Debug::message("Dispatcher::runWeb executing $module::$controller ($endpoint)");
        $route_array = explode('|', $endpoint);
        $className = $route_array[0];
        $filename = $route_array[1];

        if (!file_exists($filename)) {
            static::dieWithMessage(\Alxarafe\Lib\Trans::_('dispatcher_file_not_found', ['file' => $filename]));
        }

        require_once $filename;

        $theme = 'default';
        $language = \Alxarafe\Lib\Trans::FALLBACK_LANG;

        try {
            $config = Config::getConfig();
            if ($config && isset($config->main)) {
                $theme = $config->main->theme ?? $theme;
                $language = $config->main->language ?? $language;
            }
        } catch (\Throwable $e) {
            // Config unavailable — use defaults
        }

        try {
            if (Auth::isLogged() && Auth::$user) {
                $userTheme = Auth::$user->getTheme();
                if (!empty($userTheme)) {
                    $theme = $userTheme;
                }

                if (!empty(Auth::$user->language)) {
                    $language = Auth::$user->language;
                }
            }
        } catch (\Throwable $e) {
            // Auth/DB unavailable — continue without user preferences
        }

        if (isset($_COOKIE['alx_theme'])) {
            $theme = $_COOKIE['alx_theme'];
        }
        if (isset($_COOKIE['alx_lang'])) {
            $language = $_COOKIE['alx_lang'];
        }

        \Alxarafe\Lib\Trans::setLang($language);

        $controllerClass = new $className();
        if (!$controllerClass instanceof ViewController) {
            static::dieWithMessage(\Alxarafe\Lib\Trans::_('dispatcher_not_view_controller', ['class' => $className]));
        }



        // Initialize APP_PATH if not defined (fallback to BASE_PATH/..)
        if (!defined('APP_PATH')) {
            $appPath = realpath(constant('BASE_PATH') . '/..');
            if (!$appPath) {
                $appPath = dirname(constant('BASE_PATH'));
            }
            define('APP_PATH', $appPath);
        }

        $templates_path = [
            // Theme override (App)
            constant('APP_PATH') . '/templates/themes/' . $theme . '/',
            // Theme override (Package)
            constant('ALX_PATH') . '/templates/themes/' . $theme . '/',

            // Module Templates (App - Higher priority)
            constant('APP_PATH') . '/Modules/' . $module . '/templates/',
            constant('APP_PATH') . '/Modules/' . $module . '/Templates/',

            // Module Templates (Package)
            constant('ALX_PATH') . '/src/Modules/' . $module . '/templates/',
            constant('ALX_PATH') . '/src/Modules/' . $module . '/Templates/',

            // App General Templates
            constant('APP_PATH') . '/templates/',

            // Package General Templates (Default)
            constant('ALX_PATH') . '/templates/',
        ];

        /**
         * If the class exists and is successfully instantiated, the module blade templates folder
         * is added, if they exist.
         */
        if (method_exists($controllerClass, 'setTemplatesPath')) {
            Debug::message('Templates: ' . $templates_path[0]);
            Debug::message('Templates: ' . $templates_path[1]);
            $controllerClass->setTemplatesPath($templates_path);
        }

        if (!method_exists($controllerClass, $method)) {
            Debug::message(\Alxarafe\Lib\Trans::_('dispatcher_method_not_found', ['method' => $method, 'class' => $className]));
            $method = 'index';
        }

        /**
         * Runs the index method to launch the controller.
         */
        $controllerClass->{$method}();

        return true;
    }

    /**
     * Track if we are already in an error state to prevent redirect loops.
     */
    private static bool $inErrorState = false;

    #[\Override]
    protected static function dieWithMessage($message)
    {
        Debug::message('WebDispatcher error: ' . $message);

        // Anti-loop: if already in error state, render directly
        if (self::$inErrorState || headers_sent()) {
            http_response_code(500);
            echo "<!DOCTYPE html><html><head><meta charset='utf-8'><title>Error</title>";
            echo "<style>body{font-family:system-ui,sans-serif;max-width:800px;margin:40px auto;padding:0 20px;background:#1a1a2e;color:#e0e0e0}";
            echo "h1{color:#e94560}pre{background:#16213e;padding:16px;border-radius:8px;overflow-x:auto;border:1px solid #0f3460}</style></head>";
            echo "<body><h1>Error</h1><pre>" . htmlspecialchars($message) . "</pre></body></html>";
            exit;
        }

        self::$inErrorState = true;
        Functions::httpRedirect(ErrorController::url(true, false) . '&message=' . urlencode($message));
    }
}
