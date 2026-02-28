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

/* Copyright (C) 2024       Rafael San José         <rsanjose@alxarafe.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 * or see https://www.gnu.org/
 *
 */

namespace Alxarafe\Lib;

abstract class Routes
{
    private static $routes = [];

    private static $search_routes = [
        'Modules' => 'Modules/',
        'CoreModules' => 'vendor/alxarafe/alxarafe/src/Modules/',
    ];

    public static function addRoutes(array $routes = [])
    {
        self::$routes = [];
        self::$search_routes = array_merge($routes, self::$search_routes);
    }

    private static function getRoutesFor($class_type, $suffix): array
    {
        $routes = [];

        $scanned_paths = [];

        foreach (self::$search_routes as $class => $route) {
            $full_path = '';
            if ($class === 'Modules' && defined('APP_PATH')) {
                $full_path = realpath(constant('APP_PATH') . '/Modules/');
            } elseif ($class === 'CoreModules' && defined('ALX_PATH')) {
                $full_path = realpath(constant('ALX_PATH') . '/src/Modules/');
            }

            if (empty($full_path)) {
                $full_path = realpath(constant('BASE_PATH') . '/../' . $route);
            }

            if (empty($full_path) || in_array($full_path, $scanned_paths)) {
                continue;
            }
            $scanned_paths[] = $full_path;

            $modules = glob($full_path . '/*', GLOB_ONLYDIR);

            foreach ($modules as $module_path) {
                $module = basename($module_path);
                $data = glob($module_path . '/' . $class_type . '/*' . $suffix . '.php');

                foreach ($data as $filename) {
                    $class_only_name = basename($filename, $suffix . '.php');
                    $class_name = "$class\\$module\\$class_type\\$class_only_name$suffix";

                    $routes[$module][$class_only_name] = $class_name . '|' . $filename;
                }
            }
        }

        return $routes;
    }

    public static function getAllRoutes()
    {
        if (!empty(self::$routes)) {
            return self::$routes;
        }

        $routes = [
            'Controller' => 'Controller',
            'Api' => 'Controller',
            'Model' => '',
            'Migrations' => '',
            'Seeders' => '',
        ];

        foreach ($routes as $class_type => $suffix) {
            self::$routes[$class_type] = self::getRoutesFor($class_type, $suffix);
        }

        return self::$routes;
    }
}
