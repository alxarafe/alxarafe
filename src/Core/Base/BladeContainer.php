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

namespace Alxarafe\Base;

use Illuminate\Container\Container;

class BladeContainer extends Container
{
    /**
     * Mock terminating method required by Illuminate\View\ViewServiceProvider
     * but missing in the base Container.
     * 
     * @param mixed $callback
     * @return void
     */
    public function terminating($callback)
    {
        // No-op for standalone Blade usage
    }
}
