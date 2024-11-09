<?php

/* Copyright (C) 2024      Rafael San José      <rsanjose@alxarafe.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace Alxarafe\Lib;

use Alxarafe\Base\Controller\ApiController;
use Alxarafe\Tools\Debug;
use CoreModules\Admin\Controller\Error404Controller;
use DebugBar\DebugBarException;

class Dispatcher
{
    /**
     * Get variable containing the name of the module to which the controller to be executed belongs.
     */
    public const MODULE = 'module';

    /**
     * Get variable containing the name of the controller to execute.
     */
    public const CONTROLLER = 'controller';

    /**
     * Get variable containing the name of the method to execute.
     * Not normally used. The action is executed automatically from the index method.
     */
    private const METHOD = 'method';

    /**
     * Run de selected controller.
     * Discriminates by URL whether to paint a web page, or return an API response.
     *
     * @throws DebugBarException
     */
    public static function run($alternative_routes = []): void
    {
        self::initialize();

        $to_search = '/index.php/api/';
        $route = $_SERVER['PHP_SELF'];
        $pos = strpos($route, $to_search);
        if ($pos !== false) {
            $controller = substr($route, $pos + strlen($to_search));
            static::runApi($controller, $alternative_routes);
            return;
        }

        $module = filter_input(INPUT_GET, static::MODULE) ?? 'Admin';
        $controller = filter_input(INPUT_GET, static::CONTROLLER) ?? 'Info';
        $method = filter_input(INPUT_GET, static::METHOD) ?? 'index';
        if (!static::runWeb($module, $controller, $method, $alternative_routes)) {
            new Error404Controller();
        }
    }

    /**
     * Initializes all the utilities and libraries of the framework environment.
     *
     * @return void
     * @throws DebugBarException
     */
    private static function initialize()
    {
        self::initializeConstants();

        Trans::initialize();
    }

    private static function initializeConstants()
    {
        /**
         * Define BASE_PATH if it does not exist.
         * It's usually created in main index.php.
         * It's the full path to the public folder.
         */
        Functions::defineIfNotDefined('ALX_PATH', realpath(__DIR__ . '/../../..'));
        Functions::defineIfNotDefined('APP_PATH', realpath(constant('ALX_PATH') . '/../../..'));
        Functions::defineIfNotDefined('BASE_PATH', constant('APP_PATH') . '/public');
        Functions::defineIfNotDefined('BASE_URL', Functions::getUrl());
    }

    private static function runApi($route, $alternative_routes)
    {
        $array = explode('/', $route);
        $module = $array[0];
        $controller = $array[1] ?? null;
        $method = $array[2] ?? null;

        $routes = Routes::getAllRoutes();
        $endpoint = $routes['Api'][$module][$controller] ?? null;
        if ($endpoint === null) {
            Debug::message("Dispatcher::runApi error: $route does not exists");
            ApiController::badApiCall();
        }

        Debug::message("Dispatcher::runApi executing $route ($endpoint)");
        $route_array = explode('|', $endpoint);
        $class_name = $route_array[0];
        $filename = $route_array[1];

        if (!file_exists($filename)) {
            Debug::message("Dispatcher::runApi error: $filename does not exists");
            ApiController::badApiCall();
        }

        require_once $filename;

        $controller = new $class_name();
        if ($controller === null) {
            Debug::message("Dispatcher::runApi error: $class_name not found");
            ApiController::badApiCall();
        }
    }

    /**
     * Run the controller for the indicated module, if it exists.
     * Returns true if it can be executed.
     *
     * @param string $module
     * @param string $controller
     * @param string $method
     * @param array $alternative_routes
     *
     * @return bool
     * @throws DebugBarException
     */
    private static function runWeb(string $module, string $controller, string $method, array $alternative_routes): bool
    {
        Debug::initialize();

        $routes = Routes::getAllRoutes();
        $endpoint = $routes['Controller'][$module][$controller] ?? null;
        if ($endpoint === null) {
            Debug::message("Dispatcher::runWeb error: $module::$controller does not exists");
            new Error404Controller();
            return false;
        }

        Debug::message("Dispatcher::runWeb executing $module::$controller ($endpoint)");
        $route_array = explode('|', $endpoint);
        $class_name = $route_array[0];
        $filename = $route_array[1];

        if (!file_exists($filename)) {
            Debug::message("Dispatcher::runWeb error: $filename does not exists");
            new Error404Controller();
            return false;
        }

        require_once $filename;

        $controller = new $class_name();
        if ($controller === null) {
            Debug::message("Dispatcher::runApi error: $class_name not found");
            new Error404Controller();
            return false;
        }

        $templates_path = [
            constant('ALX_PATH') . '/src/Modules/' . $module . '/Templates/',
            constant('BASE_PATH') . '/../Modules/' . $module . '/Templates/',
        ];

        /**
         * If the class exists and is successfully instantiated, the module blade templates folder
         * is added, if they exist.
         */
        if (method_exists($controller, 'setTemplatesPath')) {
            Debug::message('Templates: ' . $templates_path[0]);
            Debug::message('Templates: ' . $templates_path[1]);
            $controller->setTemplatesPath($templates_path);
        }

        if (!method_exists($controller, $method)) {
            Debug::message('Method ' . $method . ' not found in controller ' . $class_name);
            $method = 'index';
        }

        /**
         * Runs the index method to launch the controller.
         */
        $controller->{$method}();

        return true;
    }

    /**
     * Process modern application controller paths.
     *
     * @param string $class
     * @param string $route
     * @param string $module
     * @param string $controller
     * @param string $method
     * @return bool
     */
    private static function processFolder(string $class, string $route, string $module, string $controller, string $method = 'index'): bool
    {
        /**
         * Defines the full path ($realpath) to the modules folder ($route).
         */
        $realpath = realpath(constant('APP_PATH') . '/' . $route);

        /**
         * Adds the module to the path ($basepath), if it's a module.
         */
        $basepath = $realpath;
        if (!empty($module)) {
            $basepath = $realpath . '/' . $module;
        }

        /**
         * Defines full classname and filename
         */
        $className = $class . '\\' . $module . '\\Controller\\' . $controller;
        $filename = $basepath . '/Controller/' . $controller . '.php';

        Debug::message('Filename: ' . $filename);
        Debug::message('Class: ' . $className);
        if (!file_exists($filename)) {
            return false;
        }

        require_once $filename;

        $controller = new $className();
        if ($controller === null) {
            return false;
        }

        /**
         * If the class exists and is successfully instantiated, the module blade templates folder
         * is added, if they exist.
         */
        if (method_exists($controller, 'setTemplatesPath')) {
            $templates_path = $basepath . '/Templates';
            Debug::message('Templates: ' . $templates_path);
            $controller->setTemplatesPath($templates_path);
        }

        if (!method_exists($controller, $method)) {
            Debug::message('Method ' . $method . ' not found in controller ' . $className);
            $method = 'index';
        }

        /**
         * Runs the index method to launch the controller.
         */
        $controller->{$method}();

        return true;
    }
}
