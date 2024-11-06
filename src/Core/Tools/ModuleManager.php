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
 * along with this program. If not, see <https:\\www.gnu.org/licenses/>.
 */

namespace Alxarafe\Tools;

abstract class ModuleManager
{
    /**
     * Regenerate menus and actions.
     * This is temporary, everything will be cached by user or role.
     *
     * @return void
     */
    public static function regenerate()
    {
        dump([
            'acciones' => self::getActions(),
            'menú refactorizado' => self::getArrayMenu(),
            'menú lateral' => self::getArraySidebarMenu()
        ]);
    }

    /**
     * Returns an associative array with the actions of each controller,
     * the index being the namespace of the controller.
     *
     * @return array
     */
    private static function getActions()
    {
        $result = [];
        $menuOptions = self::iterateFunction('getActions');
        foreach ($menuOptions as $option) {
            if ($option === false) {
                continue;
            }
            $result = array_merge($result, $option);
        }
        return $result;
    }

    /**
     * Generates an array in which each element is the result of calling the
     * $function function for each controller in the application.
     *
     * @param $function
     * @return array
     */
    private static function iterateFunction($function)
    {
        $iterate = static::iterate();
        $result = [];
        foreach ($iterate as $module) {
            $namespace = $module['namespace'];
            if (!method_exists($namespace, $function)) {
                continue;
            }
            $result[$namespace] = $namespace::$function();
        }
        return $result;
    }

    private static function iterate()
    {
        $routes = self::routes();
        $data = [];
        foreach ($routes as $route) {
            $data = array_merge($data, self::getModuleControllers($route['namespace'], $route['path']));
        }
        return $data;
    }

    /**
     * Returns the paths that can contain modules.
     *
     * @return string[]
     */
    private static function routes(): array
    {
        $base_path = realpath(constant('BASE_PATH') . '/..');
        $result = [];
        $result[] = [
            'path' => $base_path . '/vendor/rsanjoseo/alxarafe/src/Modules',
            'namespace' => 'CoreModules',
        ];
        $result[] = [
            'path' => $base_path . '/Modules',
            'namespace' => 'Modules',
        ];
        return $result;
    }

    /**
     * Returns an array with the module drivers included in the $path folder.
     * The array contains the name, namespace and path of those controllers.
     *
     * @param string $namespace
     * @param string $path
     * @return array
     */
    private static function getModuleControllers(string $namespace, string $path): array
    {
        $result = [];
        if (!is_dir($path)) {
            return [];
        }
        $directories = scandir($path);
        foreach ($directories as $directory) {
            if ($directory === '.' || $directory === '..' || !is_dir($path . '/' . $directory)) {
                continue;
            }
            $result = array_merge($result, self::getControllers($namespace . '\\' . $directory, $path, $directory));
        }
        return $result;
    }

    /**
     * Returns an array with the specified $path and $directory controllers.
     * The array contains the name, namespace and path of those controllers.
     *
     * @param string $namespace
     * @param string $path
     * @param string $directory
     * @return array
     */
    private static function getControllers(string $namespace, string $path, string $directory): array
    {
        $result = [];
        $files = scandir($path . '/' . $directory . '/Controller');
        foreach ($files as $file) {
            if ($file === '.' || $file === '..' || !str_ends_with($file, '.php')) {
                continue;
            }
            $name = substr($file, 0, -4);
            $result[] = [
                'name' => $name,
                'namespace' => $namespace . '\\Controller\\' . $name,
                'path' => $path . '/' . $directory . '/Controller/' . $file,
            ];
        }
        return $result;
    }

    /**
     * Regenerate the top menu.
     * This is temporary.
     * The menus to be displayed will be cached by user or role.
     *
     * @return array|mixed
     */
    public static function getArrayMenu()
    {
        return self::buildMultiLevelMenu(self::getMenu());
    }

    /**
     * Converts an array where the index is a menu path with the
     * hierarchy separated by pipelines, to a nested array.
     *
     * @param $menuOptions
     * @return array|mixed
     */
    private static function buildMultiLevelMenu($menuOptions)
    {
        $result = [];

        foreach ($menuOptions as $option => $value) {
            $levels = explode('|', $option);
            $numberOfLevels = count($levels);
            $currentLevel = &$result;

            foreach ($levels as $level) {
                $numberOfLevels--;
                if ($numberOfLevels === 0) {
                    $currentLevel[$level] = $value;
                    continue;
                }
                if (!isset($currentLevel[$level])) {
                    $currentLevel[$level] = [];
                }
                $currentLevel = &$currentLevel[$level];
            }
        }

        return $result;
    }

    /**
     * Obtains an array with all the menu options where the index is the
     * option and the value is the url of the controller to be executed.
     *
     * Example: ['admin|auth'] = "index.php?module=Admin&controller=Auth"
     *
     * @return array
     */
    private static function getMenu()
    {
        $result = [];
        $menuOptions = self::iterateFunction('getMenu');
        foreach ($menuOptions as $namespace => $option) {
            if ($option === false) {
                continue;
            }
            $url = self::getUrl($namespace);
            if ($url === false) {
                continue;
            }
            $result[$option] = $url;
        }
        return $result;
    }

    /**
     * Returns the URL that runs the controller with the given namespace.
     *
     * The namespace can be:
     * - CoreModules\\<module>\\Controller\\<controller>Controller
     * - Modules\\<module>\\Controller\\<controller>Controller
     *
     * @param $namespace
     * @return false|string
     */
    public static function getUrl($namespace)
    {
        $explode = explode('\\', $namespace);
        if (count($explode) < 4) {
            return false;
        }
        $name = $explode[3];
        if (!str_ends_with($name, 'Controller')) {
            return false;
        }
        $controller = substr($name, 0, -10);
        $module = $explode[1];

        return 'index.php?module=' . $module . '&controller=' . $controller;
    }

    /**
     * Regenerate the sidebar menu.
     * This is temporary.
     * The menus to be displayed will be cached by user or role.
     *
     * @return array|mixed
     */
    public static function getArraySidebarMenu()
    {
        return self::buildMultiLevelMenu(self::getSidebarMenu());
    }

    private static function getSidebarMenu()
    {
        $result = [];
        $menuOptions = self::iterateFunction('getSidebarMenu');
        foreach ($menuOptions as $namespace => $option) {
            if ($option === false) {
                continue;
            }
            $url = self::getUrl($namespace);
            if ($url === false) {
                continue;
            }
            foreach ($option['options'] as $value) {
                $result[$option['base']][$value['option']] = $url;
            }
        }
        return $result;
    }
}
