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

class Dispatcher
{
    public function __construct()
    {
        new Globals();
    }

    public function run(): bool
    {
        $module = ucfirst($_GET[Globals::MODULE_GET_VAR] ?? Globals::DEFAULT_MODULE_NAME);
        $controller = ucfirst($_GET[Globals::CONTROLLER_GET_VAR] ?? Globals::DEFAULT_CONTROLLER_NAME);
        Debug::addMessage('messages', "Dispatcher::process() trying for '$module':'$controller'");
        if ($this->processFolder($module, $controller)) {
            Debug::addMessage('messages', "Dispatcher::process(): Ok");
            return true;
        }
        return false;
    }

    public function processFolder(string $module, string $controller, string $method = 'main'): bool
    {
        $className = 'Modules\\' . $module . '\\Controllers\\' . $controller;
        $filename = constant('BASE_FOLDER') . '/Modules/' . $module . '/Controllers/' . $controller . '.php';
        if (file_exists($filename)) {
            Debug::addMessage('messages', "$className exists!");
            $controller = new $className();
            $controller->{$method}();
            return true;
        }
        return false;
    }
}
