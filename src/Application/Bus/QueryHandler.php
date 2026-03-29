<?php

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
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

namespace Alxarafe\Application\Bus;

/**
 * QueryHandler — Interface for query handlers (read use cases).
 *
 * Each handler resolves a single type of Query, returning data
 * without side effects.
 *
 * @package Alxarafe\Application\Bus
 */
interface QueryHandler
{
    /**
     * Handle the given query and return the result.
     *
     * @param Query $query The query to handle.
     *
     * @return mixed The query result.
     */
    public function handle(Query $query): mixed;
}
