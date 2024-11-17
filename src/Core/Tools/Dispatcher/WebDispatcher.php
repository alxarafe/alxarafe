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

namespace Alxarafe\Tools\Dispatcher;

use Alxarafe\Lib\Routes;
use Alxarafe\Tools\Debug;
use CoreModules\Admin\Controller\Error404Controller;
use DebugBar\DebugBarException;

class WebDispatcher extends Dispatcher
{
    protected static function dieWithMessage($message)
    {
        Debug::message('WebDispatcher error: ' . $message);
        new Error404Controller();
        die();
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
            return false;
        }

        Debug::message("Dispatcher::runWeb executing $module::$controller ($endpoint)");
        $route_array = explode('|', $endpoint);
        $className = $route_array[0];
        $filename = $route_array[1];

        if (!file_exists($filename)) {
            Debug::message("Dispatcher::runWeb error: $filename does not exists");
            new Error404Controller();
            return false;
        }

        require_once $filename;

        $controller = new $className();
        if ($controller === null) {
            Debug::message("Dispatcher::runApi error: $className not found");
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
