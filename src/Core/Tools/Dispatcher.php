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
use Alxarafe\Lib\Routes;
use Alxarafe\Lib\Trans;
use Alxarafe\Tools\Dispatcher\ApiDispatcher;
use Alxarafe\Tools\Dispatcher\WebDispatcher;
use DebugBar\DebugBarException;

class Dispatcher
{
    /**
     * Get variable containing the name of the module to which the controller to be executed belongs.
     */
    public const MODULE = 'module';

    /**
     * Get variable containing the name of the controller to execute.
     */
    public const CONTROLLER = 'controller';

    /**
     * Get variable containing the name of the method to execute.
     * Not normally used. The action is executed automatically from the index method.
     */
    private const METHOD = 'method';

    /**
     * Run de selected controller.
     * Discriminates by URL whether to paint a web page, or return an API response.
     *
     * @throws DebugBarException
     */
    public static function run($alternative_routes = []): void
    {
        self::initialize();

        if (!empty($alternative_routes)) {
            Routes::addRoutes($alternative_routes);
        }

        $to_search = '/index.php/api/';
        $route = $_SERVER['PHP_SELF'];
        $pos = strpos($route, $to_search);
        if ($pos !== false) {
            $controller = substr($route, $pos + strlen($to_search));
            ApiDispatcher::run($controller);
            return;
        }

        $module = filter_input(INPUT_GET, static::MODULE) ?? 'Admin';
        $controller = filter_input(INPUT_GET, static::CONTROLLER) ?? 'Info';
        $method = filter_input(INPUT_GET, static::METHOD) ?? 'index';
        WebDispatcher::run($module, $controller, $method);
    }

    /**
     * Initializes all the utilities and libraries of the framework environment.
     *
     * @return void
     * @throws DebugBarException
     */
    private static function initialize()
    {
        self::initializeConstants();

        Trans::initialize();
    }

    private static function initializeConstants()
    {
        /**
         * Define BASE_PATH if it does not exist.
         * It's usually created in main index.php.
         * It's the full path to the public folder.
         */
        Functions::defineIfNotDefined('ALX_PATH', realpath(__DIR__ . '/../../..'));
        Functions::defineIfNotDefined('APP_PATH', realpath(constant('ALX_PATH') . '/../../..'));
        Functions::defineIfNotDefined('BASE_PATH', constant('APP_PATH') . '/public');
        Functions::defineIfNotDefined('BASE_URL', Functions::getUrl());
    }
}
