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

namespace Alxarafe\Infrastructure\Container;

/**
 * ServiceContainer — Lightweight IoC (Inversion of Control) container.
 *
 * Provides dependency injection through explicit binding and resolution.
 * Intentionally minimal (~100 lines) to keep Alxarafe lightweight.
 * No auto-wiring, no reflection — explicit is better than implicit.
 *
 * Usage:
 *   $container = new ServiceContainer();
 *
 *   // Bind interface to implementation (new instance each time)
 *   $container->bind(PersistencePort::class, fn($c) => new PdoMysqlAdapter($config));
 *
 *   // Bind as singleton (same instance reused)
 *   $container->singleton(CommandBusPort::class, fn($c) => new SimpleCommandBus());
 *
 *   // Resolve
 *   $db = $container->get(PersistencePort::class);
 *
 * @package Alxarafe\Infrastructure\Container
 */
class ServiceContainer
{
    /**
     * Factory bindings.
     *
     * @var array<string, callable>
     */
    private array $bindings = [];

    /**
     * Resolved singleton instances.
     *
     * @var array<string, mixed>
     */
    private array $instances = [];

    /**
     * Track which bindings are singletons.
     *
     * @var array<string, bool>
     */
    private array $singletons = [];

    /**
     * Register a binding (new instance created on each resolution).
     *
     * @param string   $abstract The interface or class name to bind.
     * @param callable $factory  Factory function receiving the container: fn(ServiceContainer) => instance.
     */
    public function bind(string $abstract, callable $factory): void
    {
        $this->bindings[$abstract] = $factory;
        unset($this->singletons[$abstract], $this->instances[$abstract]);
    }

    /**
     * Register a singleton binding (same instance reused after first resolution).
     *
     * @param string   $abstract The interface or class name to bind.
     * @param callable $factory  Factory function receiving the container.
     */
    public function singleton(string $abstract, callable $factory): void
    {
        $this->bindings[$abstract] = $factory;
        $this->singletons[$abstract] = true;
        unset($this->instances[$abstract]);
    }

    /**
     * Register a pre-built instance directly.
     *
     * @param string $abstract The interface or class name.
     * @param mixed  $instance The already-constructed instance.
     */
    public function instance(string $abstract, mixed $instance): void
    {
        $this->instances[$abstract] = $instance;
        $this->singletons[$abstract] = true;
    }

    /**
     * Resolve a binding.
     *
     * @param string $abstract The interface or class name to resolve.
     *
     * @return mixed The resolved instance.
     *
     * @throws \RuntimeException If no binding exists for the given abstract.
     */
    public function get(string $abstract): mixed
    {
        // Return existing singleton instance
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        // Check for a registered factory
        if (!isset($this->bindings[$abstract])) {
            throw new \RuntimeException(
                "No binding registered for: {$abstract}"
            );
        }

        $instance = ($this->bindings[$abstract])($this);

        // Cache if singleton
        if (isset($this->singletons[$abstract])) {
            $this->instances[$abstract] = $instance;
        }

        return $instance;
    }

    /**
     * Check if a binding exists for the given abstract.
     *
     * @param string $abstract The interface or class name.
     *
     * @return bool True if a binding or instance exists.
     */
    public function has(string $abstract): bool
    {
        return isset($this->bindings[$abstract]) || isset($this->instances[$abstract]);
    }

    /**
     * Remove a binding and its cached instance.
     *
     * @param string $abstract The interface or class name.
     */
    public function forget(string $abstract): void
    {
        unset(
            $this->bindings[$abstract],
            $this->instances[$abstract],
            $this->singletons[$abstract]
        );
    }

    /**
     * Get all registered binding keys.
     *
     * @return string[]
     */
    public function getBindings(): array
    {
        return array_unique(
            array_merge(array_keys($this->bindings), array_keys($this->instances))
        );
    }
}
