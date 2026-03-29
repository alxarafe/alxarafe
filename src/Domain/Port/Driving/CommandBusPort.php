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

namespace Alxarafe\Domain\Port\Driving;

use Alxarafe\Application\Bus\Command;

/**
 * CommandBusPort — Primary (driving) port for dispatching commands.
 *
 * Orchestrates the execution of use cases (Handlers) in a decoupled
 * manner, separating controllers from business logic.
 *
 * @package Alxarafe\Domain\Port\Driving
 */
interface CommandBusPort
{
    /**
     * Dispatch a command to its registered handler.
     *
     * @param Command $command The command to dispatch.
     *
     * @return mixed The handler's return value (if any).
     *
     * @throws \RuntimeException If no handler is registered for the command.
     */
    public function dispatch(Command $command): mixed;
}
