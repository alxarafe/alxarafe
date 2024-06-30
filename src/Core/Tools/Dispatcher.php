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

namespace Alxarafe\Tools;

use Alxarafe\Lib\Functions;

class Dispatcher
{
    /**
     * Run the controller for the indicated module, if it exists.
     * Returns true if it can be executed.
     *
     * @param string $module
     * @param string $controller
     * @param array $alternative_routes
     *
     * @return bool
     */
    public static function run(string $module, string $controller, array $alternative_routes = []): bool
    {
        /**
         * Adding core module path
         */
        $routes = array_merge($alternative_routes, [
            'CoreModules' => 'vendor/rsanjoseo/alxarafe/src/Modules/',
        ]);
        $controller .= 'Controller';
        foreach ($routes as $class => $route) {
            if (static::processFolder($class, $route, $module, $controller)) {
                Debug::message("Dispatcher::process(): Ok");
                return true;
            }
        }
        Debug::message("Dispatcher::fail(): $module:$controller.");
        return false;
    }

    /**
     * Process modern application controller paths.
     *
     * @param string $module
     * @param string $controller
     * @return bool
     */
    private static function processFolder($class, $route, string $module, string $controller): bool
    {
        Functions::defineIfNotDefined('BASE_PATH', realpath(__DIR__ . '/../../../../../..') . '/public');

        $realpath = realpath(constant('BASE_PATH') . '/..') . '/' . $route;
        $basepath = $realpath;
        if (!empty($module)) {
            $basepath = $realpath . '/' . $module;
        }
        $className = $class . '\\' . $module . '\\Controller\\' . $controller;
        $filename = $basepath . '/Controller/' . $controller . '.php';

        Debug::message('Filename: ' . $filename);
        Debug::message('Class: ' . $className);
        if (!file_exists($filename)) {
            return false;
        }

        $controller = new $className();
        if ($controller === null) {
            return false;
        }

        if (method_exists($controller, 'setTemplatesPath')) {
            $templates_path = $basepath . '/Templates';
            Debug::message('Templates: ' . $templates_path);
            $controller->setTemplatesPath($templates_path);
        }
        $controller->index();

        return true;
    }
}
