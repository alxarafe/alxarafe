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

namespace Alxarafe\Tools;

use Alxarafe\Lib\Auth;

abstract class ModuleManager
{
    /**
     * Callback para determinar si un módulo está activo.
     * @var callable|null
     */
    private static $activationChecker = null;

    /**
     * Establece el verificador de activación de módulos.
     * 
     * @param callable $checker Función que recibe el nombre del módulo y devuelve bool
     */
    public static function setActivationChecker(callable $checker): void
    {
        self::$activationChecker = $checker;
    }
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
        $iterate = self::iterate();
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
            $modulesPath = $route['path'];
            if (!is_dir($modulesPath)) continue;

            $modules = scandir($modulesPath);
            foreach ($modules as $moduleName) {
                if ($moduleName === '.' || $moduleName === '..' || !is_dir($modulesPath . '/' . $moduleName)) {
                    continue;
                }

                // Verificar si el módulo está activo antes de procesar sus controladores
                if (self::isModuleActive($moduleName, $route['namespace'])) {
                    $data = array_merge($data, self::getControllers(
                        $route['namespace'] . '\\' . $moduleName,
                        $modulesPath,
                        $moduleName
                    ));
                }
            }
        }
        return $data;
    }

    /**
     * Verifica si un módulo está activado en el sistema.
     */
    private static function isModuleActive(string $moduleName, string $namespace): bool
    {
        // Los módulos del Core siempre están activos
        if ($namespace === 'CoreModules') {
            return true;
        }

        if (self::$activationChecker !== null) {
            return (bool) call_user_func(self::$activationChecker, $moduleName);
        }

        // Por defecto, si no hay checker, el módulo está activo si la carpeta existe
        return true;
    }

    /**
     * Returns the paths that can contain modules.
     *
     * @return array<int, array<string, string>>
     */
    private static function routes(): array
    {
        $base_path = realpath(constant('BASE_PATH') . '/..');
        $result = [];
        $result[] = [
            'path' => $base_path . '/vendor/alxarafe/alxarafe/src/Modules',
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
