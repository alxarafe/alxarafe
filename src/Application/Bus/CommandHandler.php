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
 * CommandHandler — Interface for command handlers (use cases).
 *
 * Each handler implements a single use case. The command bus maps
 * Command classes to their corresponding Handler.
 *
 * Example:
 *   class CreateJokeHandler implements CommandHandler {
 *       public function __construct(private JokeRepository $repo) {}
 *       public function handle(Command $command): mixed {
 *           $joke = new Joke($command->title, $command->body);
 *           $this->repo->save($joke);
 *           return $joke->getId();
 *       }
 *   }
 *
 * @package Alxarafe\Application\Bus
 */
interface CommandHandler
{
    /**
     * Handle the given command.
     *
     * @param Command $command The command to handle.
     *
     * @return mixed The result of handling the command (if any).
     */
    public function handle(Command $command): mixed;
}
