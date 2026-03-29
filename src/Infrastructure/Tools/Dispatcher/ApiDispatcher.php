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

namespace Alxarafe\Infrastructure\Tools\Dispatcher;

use Alxarafe\Infrastructure\Http\Controller\ApiController;
use Alxarafe\Infrastructure\Http\Routes;
use Alxarafe\Infrastructure\Tools\Debug;
use Alxarafe\Infrastructure\Service\ApiRouter;
use Alxarafe\Infrastructure\Service\ApiDispatcher as NewApiDispatcher;

class ApiDispatcher extends Dispatcher
{
    #[\Override]
    protected static function dieWithMessage($message)
    {
        Debug::message('ApiDispatcher error:');
        ApiController::badApiCall();
    }

    /**
     * Run the API call using the new Attribute-based Router.
     * Execution dies with a json response.
     *
     * @param $route unused here since the new Service\ApiDispatcher reads $_SERVER['REQUEST_URI']
     * @return void
     */
    public static function run($route)
    {
        Debug::message("ApiDispatcher::run delegating to new Attribute-based Router");
        
        $router = new \Alxarafe\Infrastructure\Service\ApiRouter();
        $dispatcher = new \Alxarafe\Infrastructure\Service\ApiDispatcher($router);
        
        $dispatcher->dispatch();
    }
}
