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
 * Command — Marker interface for command objects.
 *
 * Commands represent the intention to perform an action that changes state.
 * They are immutable DTOs carrying all the data needed to execute a use case.
 *
 * Example:
 *   class CreateJokeCommand implements Command {
 *       public function __construct(
 *           public readonly string $title,
 *           public readonly string $body,
 *           public readonly int $authorId,
 *       ) {}
 *   }
 *
 * @package Alxarafe\Application\Bus
 */
interface Command
{
}
