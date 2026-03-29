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

namespace Alxarafe\Infrastructure\Adapter\Persistence;

use Alxarafe\Domain\Port\Driven\PersistencePort;
use Illuminate\Database\Capsule\Manager as CapsuleManager;

/**
 * EloquentBridgeAdapter — Bridge adapter for backward compatibility.
 *
 * Implements PersistencePort by delegating to the existing Illuminate/Eloquent
 * Capsule Manager. This allows hexagonal code to work alongside legacy code
 * that still uses Eloquent directly.
 *
 * Use this adapter during migration. For new applications, prefer PdoMysqlAdapter.
 *
 * @package Alxarafe\Infrastructure\Adapter\Persistence
 */
class EloquentBridgeAdapter implements PersistencePort
{
    private string $primaryKey;

    /**
     * @param string $primaryKey Default primary key column name.
     */
    public function __construct(string $primaryKey = 'id')
    {
        $this->primaryKey = $primaryKey;

        // Ensure Capsule is booted — the legacy Database class sets it as global
        if (!CapsuleManager::schema()->getConnection()->getPdo()) {
            throw new \RuntimeException(
                'EloquentBridgeAdapter requires an active Capsule connection. '
                . 'Ensure Database::createConnection() has been called.'
            );
        }
    }

    /** @inheritDoc */
    public function findById(string $table, int|string $id): ?array
    {
        $result = CapsuleManager::table($table)
            ->where($this->primaryKey, $id)
            ->first();

        return $result ? (array) $result : null;
    }

    /** @inheritDoc */
    public function findBy(
        string $table,
        array $criteria = [],
        array $orderBy = [],
        ?int $limit = null,
        ?int $offset = null
    ): array {
        $query = CapsuleManager::table($table);

        foreach ($criteria as $column => $value) {
            if ($value === null) {
                $query->whereNull($column);
            } else {
                $query->where($column, $value);
            }
        }

        foreach ($orderBy as $column => $direction) {
            $query->orderBy($column, $direction);
        }

        if ($limit !== null) {
            $query->limit($limit);
        }
        if ($offset !== null) {
            $query->offset($offset);
        }

        return array_map(fn($row) => (array) $row, $query->get()->all());
    }

    /** @inheritDoc */
    public function findOneBy(string $table, array $criteria): ?array
    {
        $query = CapsuleManager::table($table);

        foreach ($criteria as $column => $value) {
            if ($value === null) {
                $query->whereNull($column);
            } else {
                $query->where($column, $value);
            }
        }

        $result = $query->first();
        return $result ? (array) $result : null;
    }

    /** @inheritDoc */
    public function insert(string $table, array $data): int|string
    {
        return (string) CapsuleManager::table($table)->insertGetId($data);
    }

    /** @inheritDoc */
    public function update(string $table, int|string $id, array $data): bool
    {
        $affected = CapsuleManager::table($table)
            ->where($this->primaryKey, $id)
            ->update($data);

        return $affected > 0;
    }

    /** @inheritDoc */
    public function delete(string $table, int|string $id): bool
    {
        $affected = CapsuleManager::table($table)
            ->where($this->primaryKey, $id)
            ->delete();

        return $affected > 0;
    }

    /** @inheritDoc */
    public function transactional(callable $callback): mixed
    {
        return CapsuleManager::connection()->transaction($callback);
    }

    /** @inheritDoc */
    public function rawQuery(string $sql, array $params = []): array
    {
        $results = CapsuleManager::select($sql, $params);
        return array_map(fn($row) => (array) $row, $results);
    }

    /** @inheritDoc */
    public function exists(string $table, int|string $id): bool
    {
        return CapsuleManager::table($table)
            ->where($this->primaryKey, $id)
            ->exists();
    }

    /** @inheritDoc */
    public function count(string $table, array $criteria = []): int
    {
        $query = CapsuleManager::table($table);

        foreach ($criteria as $column => $value) {
            if ($value === null) {
                $query->whereNull($column);
            } else {
                $query->where($column, $value);
            }
        }

        return $query->count();
    }
}
