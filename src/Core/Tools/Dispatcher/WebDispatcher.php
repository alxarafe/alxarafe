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

use Alxarafe\Base\Config;
use Alxarafe\Base\Controller\ViewController;
use Alxarafe\Lib\Functions;
use Alxarafe\Lib\Routes;
use Alxarafe\Tools\Debug;
use CoreModules\Admin\Controller\Error404Controller;
use DebugBar\DebugBarException;

class WebDispatcher extends Dispatcher
{
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
            static::dieWithMessage($module . '::' . $controller . 'does not exists');
        }

        Debug::message("Dispatcher::runWeb executing $module::$controller ($endpoint)");
        $route_array = explode('|', $endpoint);
        $className = $route_array[0];
        $filename = $route_array[1];

        if (!file_exists($filename)) {
            static::dieWithMessage($filename . 'does not exists');
        }

        require_once $filename;

        $controllerClass = new $className();
        if (!$controllerClass instanceof ViewController) {
            static::dieWithMessage($className . ' is not a ViewController');
        }

        $theme = Config::getConfig()->main->theme ?? 'default';

        $templates_path = [
            // Theme override
            constant('ALX_PATH') . '/templates/themes/' . $theme . '/',

            constant('ALX_PATH') . '/src/Modules/' . $module . '/templates/',
            constant('ALX_PATH') . '/src/Modules/' . $module . '/Templates/',
            constant('BASE_PATH') . '/../Modules/' . $module . '/templates/',
            constant('BASE_PATH') . '/../Modules/' . $module . '/Templates/',
            // Add common templates path
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
            Debug::message('Method ' . $method . ' not found in controller ' . $className);
            $method = 'index';
        }

        /**
         * Runs the index method to launch the controller.
         */
        $controllerClass->{$method}();

        return true;
    }

    #[\Override]
    protected static function dieWithMessage($message)
    {
        Debug::message('WebDispatcher error: ' . $message);
        Functions::httpRedirect(Error404Controller::url(true, false));
    }
}
