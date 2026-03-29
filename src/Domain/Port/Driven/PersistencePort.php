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

namespace Alxarafe\Domain\Port\Driven;

/**
 * PersistencePort — Secondary (driven) port for data persistence.
 *
 * This is the central infrastructure contract of Alxarafe as a Hub.
 * It operates with arrays for maximum flexibility: consuming applications
 * build their own typed Repositories on top of this port.
 *
 * @see ADR-001 in implementation_plan.md for the rationale behind using
 *      arrays instead of typed entities at the framework level.
 *
 * Architecture note:
 *   Alxarafe (framework) → PersistencePort uses `string $table` + `array`
 *   App (e.g. Chascarrillo) → JokeRepository uses `int $id` + `Joke` entity
 *   The app's Domain layer never sees tables or arrays — only typed Repositories.
 *
 * @package Alxarafe\Domain\Port\Driven
 */
interface PersistencePort
{
    /**
     * Find a single record by its primary key.
     *
     * @param string     $table The table/collection name.
     * @param int|string $id    The primary key value.
     *
     * @return array<string, mixed>|null The record as an associative array, or null if not found.
     */
    public function findById(string $table, int|string $id): ?array;

    /**
     * Find records matching the given criteria.
     *
     * @param string               $table   The table/collection name.
     * @param array<string, mixed> $criteria Key-value pairs for WHERE conditions (AND).
     * @param array<string, string> $orderBy  Column => direction ('ASC'|'DESC').
     * @param int|null             $limit   Maximum number of results.
     * @param int|null             $offset  Number of results to skip.
     *
     * @return array<int, array<string, mixed>> List of matching records.
     */
    public function findBy(
        string $table,
        array $criteria = [],
        array $orderBy = [],
        ?int $limit = null,
        ?int $offset = null
    ): array;

    /**
     * Find a single record matching the given criteria.
     *
     * @param string               $table    The table/collection name.
     * @param array<string, mixed> $criteria Key-value pairs for WHERE conditions.
     *
     * @return array<string, mixed>|null The first matching record, or null.
     */
    public function findOneBy(string $table, array $criteria): ?array;

    /**
     * Insert a new record. Returns the generated primary key.
     *
     * @param string               $table The table/collection name.
     * @param array<string, mixed> $data  Column-value pairs to insert.
     *
     * @return int|string The auto-generated ID.
     */
    public function insert(string $table, array $data): int|string;

    /**
     * Update an existing record by its primary key.
     *
     * @param string               $table The table/collection name.
     * @param int|string           $id    The primary key value.
     * @param array<string, mixed> $data  Column-value pairs to update.
     *
     * @return bool True if at least one row was affected.
     */
    public function update(string $table, int|string $id, array $data): bool;

    /**
     * Delete a record by its primary key.
     *
     * @param string     $table The table/collection name.
     * @param int|string $id    The primary key value.
     *
     * @return bool True if the record was deleted.
     */
    public function delete(string $table, int|string $id): bool;

    /**
     * Execute a callable within a database transaction.
     *
     * The transaction is committed if the callable returns without throwing.
     * It is rolled back if an exception is thrown.
     *
     * @param callable $callback The operation to execute transactionally.
     *
     * @return mixed The return value of the callable.
     *
     * @throws \Throwable Re-thrown after rollback.
     */
    public function transactional(callable $callback): mixed;

    /**
     * Execute a raw SQL query with parameter binding.
     *
     * Use this sparingly — primarily for migrations, reports, or queries
     * that cannot be expressed through the other methods.
     *
     * @param string              $sql    The SQL query with ? or :named placeholders.
     * @param array<mixed>        $params Parameters to bind.
     *
     * @return array<int, array<string, mixed>> Result rows as associative arrays.
     */
    public function rawQuery(string $sql, array $params = []): array;

    /**
     * Check if a record exists by primary key.
     *
     * @param string     $table The table/collection name.
     * @param int|string $id    The primary key value.
     *
     * @return bool True if the record exists.
     */
    public function exists(string $table, int|string $id): bool;

    /**
     * Count records matching the given criteria.
     *
     * @param string               $table    The table/collection name.
     * @param array<string, mixed> $criteria Key-value pairs for WHERE conditions.
     *
     * @return int The count of matching records.
     */
    public function count(string $table, array $criteria = []): int;
}
