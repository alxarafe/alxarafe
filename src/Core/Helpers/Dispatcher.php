<?php
/**
 * Copyright (C) 2022-2023  Rafael San José Tovar   <info@rsanjoseo.com>
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
 */

namespace Alxarafe\Core\Helpers;

use Alxarafe\Core\Singletons\Debug;

/**
 * Class Dispatcher
 *
 * Interpreta las variables GET para ejecutar el controlador del módulo indicado.
 *
 * @author  Rafael San José Tovar <info@rsanjoseo.com>
 *
 * @package Alxarafe\Core\Helpers
 */
abstract class Dispatcher
{
    /**
     * Obtiene un array con la ruta a las carpetas $folder, buscando inicialmente en el núcleo, y a continuación
     * en cada uno de los módulos.
     *
     * TODO: Es posible que haga falta una opción de buscar sólo en los activos y en un orden concreto,
     *       tomando los datos de la tabla 'modules' en lugar de tomarlos de la carpeta.
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @param $folder
     *
     * @return array
     */
    public static function getFolders($folder): array
    {
        $modulesFolder = constant('BASE_DIR') . '/Modules/';
        $folder = trim($folder, '/') . '/';

        $return = [];
        $return[] = constant('BASE_DIR') . '/src/' . $folder;
        foreach (scandir($modulesFolder) as $path) {
            if ($path === '.' || $path === '..') {
                continue;
            }
            $tableFolder = $modulesFolder . $path . '/' . $folder;
            if (is_dir($tableFolder)) {
                $return[] = $tableFolder;
            }
        }
        return $return;
    }

    /**
     * Busca archivos en las carpetas de los módulos y del núcleo, retornando un array con todos los archivos
     * encontrados.
     *
     * TODO: Hay que resolver los siguientes puntos en cuanto se comience a trabajar con módulos:
     * - Es posible que un archivo pueda estar repetido, en cuyo caso, habrá que ver cómo solventarlo.
     * - Es posible que el orden importe, por ejemplo porque un módulo sobreescriba una funcionalidad.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     * @version 2023.0105
     *
     * @param string $folder
     * @param string $extension
     *
     * @return array
     */
    public static function getFiles(string $folder, string $extension): array
    {
        if (strpos($extension, '.') !== 0) {
            $extension = '.' . $extension;
        }
        $length = strlen($extension);

        $return = [];
        foreach (self::getFolders($folder) as $path) {
            foreach (scandir($path) as $file) {
                if ($file != '.' && $file != '..' && substr($file, -$length) == $extension) {
                    $return[substr($file, 0, strlen($file) - $length)] = $path . $file;
                }
            }
        }
        return $return;
    }

    /**
     * Ejecuta el controlador del módulo indicado en la barra de direcciones por las variables GET.
     * Si tiene éxito al ejecutarlo, retorna true, si no, false.
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @return bool
     */
    public static function run(): bool
    {
        $module = ucfirst($_GET[Globals::MODULE_GET_VAR] ?? Globals::DEFAULT_MODULE_NAME);
        $controller = ucfirst($_GET[Globals::CONTROLLER_GET_VAR] ?? Globals::DEFAULT_CONTROLLER_NAME);
        Debug::message("Dispatcher::process() trying for '$module':'$controller'");
        if (self::processFolder($module, $controller)) {
            Debug::message("Dispatcher::process(): Ok");
            return true;
        }
        return false;
    }

    private static function processFolder(string $module, string $controller, string $method = 'main'): bool
    {
        if ($module === ucfirst(Globals::DEFAULT_MODULE_NAME)) {
            $className = 'Alxarafe\\Controllers\\' . $controller;
            $filename = constant('BASE_DIR') . '/src/Controllers/' . $controller . '.php';
        } else {
            $className = constant('MODULES_DIR') . '\\' . $module . '\\Controllers\\' . $controller;
            $filename = constant('BASE_DIR') . '/' . constant('MODULES_DIR') . '/' . $module . '/Controllers/' . $controller . '.php';
        }
        if (file_exists($filename)) {
            Debug::message("$className exists!");
            $controller = new $className();
            $controller->{$method}();
            return true;
        }
        return false;
    }
}
