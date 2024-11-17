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

namespace Alxarafe\Tools\Dispatcher;

abstract class Dispatcher
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

    abstract protected static function dieWithMessage($message);
}
