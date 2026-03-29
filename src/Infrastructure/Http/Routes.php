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

namespace Alxarafe\Infrastructure\Http;

abstract class Routes
{
    private static $routes = [];

    private static $search_routes = [
        'Modules' => 'Modules/',
    ];

    public static function addRoutes(array $routes = [])
    {
        self::$routes = [];
        self::$search_routes = array_merge($routes, self::$search_routes);
    }

    /**
     * Clear the static route cache.
     * Must be called after module activation/deactivation changes
     * so that the next getAllRoutes() call re-discovers active modules.
     */
    public static function invalidateCache(): void
    {
        self::$routes = [];
    }

    private static function getRoutesFor($class_type, $suffix): array
    {
        $routes = [];
        $scanned_paths = [];

        // Define search categories (Namespace Prefix => Path)
        $searchCategories = self::$search_routes;
        
        // Ensure Alxarafe Core modules are always scanned under 'Modules' namespace
        if (defined('ALX_PATH')) {
            $corePath = realpath(constant('ALX_PATH') . '/src/Modules/');
            if ($corePath) {
                $searchCategories['Modules_Core_Internal'] = $corePath;
            }
        }

        foreach ($searchCategories as $class => $route) {
            $namespacePrefix = str_starts_with($class, 'Modules') ? 'Modules' : $class;
            
            if (str_starts_with($class, 'Modules')) {
                // If it's a module route, it could be a relative path from BASE_PATH or an absolute path
                $full_path = is_dir($route) ? $route : realpath(constant('BASE_PATH') . '/../' . $route);
            } else {
                $full_path = realpath(constant('BASE_PATH') . '/../' . $route);
            }

            // Skip if path already scanned or doesn't exist
            if (empty($full_path) || !is_dir($full_path) || in_array($full_path, $scanned_paths)) {
                continue;
            }
            $scanned_paths[] = $full_path;

            $modules = glob($full_path . '/*', GLOB_ONLYDIR);

            foreach ($modules as $module_path) {
                $module = basename($module_path);

                // Check if module is active before including its routes
                if (!self::isModuleActive($module, $namespacePrefix)) {
                    continue;
                }

                $data = glob($module_path . '/' . $class_type . '/*' . $suffix . '.php');

                foreach ($data as $filename) {
                    $class_only_name = basename($filename, $suffix . '.php');
                    $class_name = "$namespacePrefix\\$module\\$class_type\\$class_only_name$suffix";

                    // Store routes - if a module/controller already exists (e.g. in App), don't overwrite with Core
                    if (!isset($routes[$module][$class_only_name])) {
                        $routes[$module][$class_only_name] = $class_name . '|' . $filename;
                    }
                }
            }
        }

        return $routes;
    }

    /**
     * Check if a module is active. Modules are always active.
     * Application modules check the settings table.
     */
    private static function isModuleActive(string $moduleName, string $namespacePrefix): bool
    {
        // Core modules are always active
        if ($namespacePrefix === 'Modules') {
            return true;
        }

        try {
            if (!class_exists('\Modules\Admin\Model\Setting')) {
                return true;
            }
            $value = \Modules\Admin\Model\Setting::get(
                'module_enabled_' . strtolower($moduleName)
            );
            if ($value === null) {
                return true; // Default enabled if no setting exists
            }
            return in_array($value, ['1', 'true', 'yes'], true);
        } catch (\Throwable $e) {
            return true; // If settings table doesn't exist yet, allow all
        }
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
