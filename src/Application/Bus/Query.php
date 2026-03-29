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
 * Query — Marker interface for query objects.
 *
 * Queries represent a request for data that does NOT change state.
 * They are the read-side counterpart of Commands (CQRS-lite).
 *
 * Example:
 *   class GetJokeByIdQuery implements Query {
 *       public function __construct(public readonly int $jokeId) {}
 *   }
 *
 * @package Alxarafe\Application\Bus
 */
interface Query
{
}
