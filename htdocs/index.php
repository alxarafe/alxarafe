<?php
/**
 * Copyright (C) 2021-2021  Rafael San José Tovar   <info@rsanjoseo.com>
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

// If it's invoked with parameters, but without the 'module' parameter,
// control is passed to Dolibarr.
if (count($_GET) > 0 && !isset($_GET['module'])) {
    include 'index_dol.php';
    die();
}

// Roll the ball...
const BASE_FOLDER = __DIR__;

$autoload_file = constant('BASE_FOLDER') . '/vendor/autoload.php';
if (!file_exists($autoload_file)) {
    die('<h1>COMPOSER ERROR</h1><p>You need to run: composer install</p>');
}

require_once $autoload_file;

$moduleName = ucfirst(filter_input(INPUT_GET, 'module') ?? 'main');
$controllerName = ucfirst(filter_input(INPUT_GET, 'controller') ?? 'init');

$className = 'Alxarafe\\Modules\\' . $moduleName . '\\' . $controllerName;
$filename = constant('BASE_FOLDER') . '/Modules/' . $moduleName . '/' . $controllerName . '.php';

if (file_exists($filename)) {
    $controller = new $className();
    $controller->run();
    die();
}

// If the controller to load cannot be found, Dolibarr is loaded
include 'index_dol.php';