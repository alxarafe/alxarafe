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

declare(strict_types=1);

namespace Alxarafe\Infrastructure\Persistence;

use Illuminate\Container\Container;

/**
 * Class BladeContainer
 *
 * Extension of Illuminate Container to provide DI for Blade components.
 */
class BladeContainer extends Container
{
    /**
     * Compatibility stub for Laravel ServiceProviders.
     */
    public function terminating($callback)
    {
        return $this;
    }

    /**
     * Compatibility stub for Laravel components.
     */
    public function getNamespace()
    {
        return 'Alxarafe\\';
    }
}
