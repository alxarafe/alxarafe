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

use Alxarafe\Domain\Port\Driving\CommandBusPort;

/**
 * SimpleCommandBus — Lightweight, explicit command/query bus.
 *
 * Maps Command/Query classes to their Handler instances using an
 * explicit registration model. No magic, no reflection, no auto-wiring.
 *
 * Usage:
 *   $bus = new SimpleCommandBus();
 *   $bus->registerCommand(CreateJokeCommand::class, new CreateJokeHandler($repo));
 *   $bus->registerQuery(GetJokeByIdQuery::class, new GetJokeByIdHandler($repo));
 *
 *   $id = $bus->dispatch(new CreateJokeCommand('Title', 'Body', 1));
 *   $joke = $bus->query(new GetJokeByIdQuery(42));
 *
 * @package Alxarafe\Application\Bus
 */
class SimpleCommandBus implements CommandBusPort
{
    /**
     * Registered command handlers.
     *
     * @var array<class-string<Command>, CommandHandler>
     */
    private array $commandHandlers = [];

    /**
     * Registered query handlers.
     *
     * @var array<class-string<Query>, QueryHandler>
     */
    private array $queryHandlers = [];

    /**
     * Register a handler for a command class.
     *
     * @param class-string<Command> $commandClass The command FQCN.
     * @param CommandHandler        $handler      The handler instance.
     */
    public function registerCommand(string $commandClass, CommandHandler $handler): void
    {
        $this->commandHandlers[$commandClass] = $handler;
    }

    /**
     * Register a handler for a query class.
     *
     * @param class-string<Query> $queryClass The query FQCN.
     * @param QueryHandler        $handler    The handler instance.
     */
    public function registerQuery(string $queryClass, QueryHandler $handler): void
    {
        $this->queryHandlers[$queryClass] = $handler;
    }

    /**
     * Dispatch a command to its registered handler.
     *
     * @param Command $command The command to dispatch.
     *
     * @return mixed The handler's return value.
     *
     * @throws \RuntimeException If no handler is registered for the command.
     */
    #[\Override]
    public function dispatch(Command $command): mixed
    {
        $commandClass = $command::class;

        if (!isset($this->commandHandlers[$commandClass])) {
            throw new \RuntimeException(
                "No handler registered for command: {$commandClass}"
            );
        }

        return $this->commandHandlers[$commandClass]->handle($command);
    }

    /**
     * Execute a query through its registered handler.
     *
     * @param Query $query The query to execute.
     *
     * @return mixed The query result.
     *
     * @throws \RuntimeException If no handler is registered for the query.
     */
    public function query(Query $query): mixed
    {
        $queryClass = $query::class;

        if (!isset($this->queryHandlers[$queryClass])) {
            throw new \RuntimeException(
                "No handler registered for query: {$queryClass}"
            );
        }

        return $this->queryHandlers[$queryClass]->handle($query);
    }

    /**
     * Check if a handler is registered for a given command class.
     *
     * @param class-string<Command> $commandClass
     */
    public function hasCommandHandler(string $commandClass): bool
    {
        return isset($this->commandHandlers[$commandClass]);
    }

    /**
     * Check if a handler is registered for a given query class.
     *
     * @param class-string<Query> $queryClass
     */
    public function hasQueryHandler(string $queryClass): bool
    {
        return isset($this->queryHandlers[$queryClass]);
    }
}
