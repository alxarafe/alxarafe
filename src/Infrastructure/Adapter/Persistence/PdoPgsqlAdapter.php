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
use PDO;

/**
 * PdoPgsqlAdapter — PostgreSQL persistence adapter using PDO.
 *
 * Functionally identical to PdoMysqlAdapter but uses PostgreSQL
 * identifier quoting (double quotes instead of backticks).
 *
 * @package Alxarafe\Infrastructure\Adapter\Persistence
 */
class PdoPgsqlAdapter implements PersistencePort
{
    private PDO $pdo;
    private string $primaryKey;

    public function __construct(
        string $host,
        string $dbName,
        string $username,
        string $password,
        int $port = 5432,
        string $primaryKey = 'id'
    ) {
        $dsn = "pgsql:host={$host};port={$port};dbname={$dbName}";

        $this->pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);

        $this->primaryKey = $primaryKey;
    }

    public static function fromConfig(\stdClass $config, string $primaryKey = 'id'): self
    {
        return new self(
            host: $config->host ?? 'localhost',
            dbName: $config->name,
            username: $config->user,
            password: $config->pass,
            port: (int) ($config->port ?? 5432),
            primaryKey: $primaryKey
        );
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    /** @inheritDoc */
    #[\Override]
    public function findById(string $table, int|string $id): ?array
    {
        $sql = 'SELECT * FROM ' . $this->qi($table) . ' WHERE ' . $this->qi($this->primaryKey) . ' = $1 LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);

        $result = $stmt->fetch();
        return $result !== false ? $result : null;
    }

    /** @inheritDoc */
    #[\Override]
    public function findBy(
        string $table,
        array $criteria = [],
        array $orderBy = [],
        ?int $limit = null,
        ?int $offset = null
    ): array {
        $sql = 'SELECT * FROM ' . $this->qi($table);
        $params = [];

        if (!empty($criteria)) {
            [$where, $params] = $this->buildWhere($criteria);
            $sql .= " WHERE {$where}";
        }

        if (!empty($orderBy)) {
            $orders = [];
            foreach ($orderBy as $column => $direction) {
                $dir = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';
                $orders[] = $this->qi($column) . " {$dir}";
            }
            $sql .= ' ORDER BY ' . implode(', ', $orders);
        }

        if ($limit !== null) {
            $sql .= " LIMIT {$limit}";
            if ($offset !== null) {
                $sql .= " OFFSET {$offset}";
            }
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    /** @inheritDoc */
    #[\Override]
    public function findOneBy(string $table, array $criteria): ?array
    {
        $results = $this->findBy($table, $criteria, [], 1);
        return $results[0] ?? null;
    }

    /** @inheritDoc */
    #[\Override]
    public function insert(string $table, array $data): int|string
    {
        $columns = array_keys($data);
        $placeholders = [];
        $i = 1;
        foreach ($columns as $ignored) {
            $placeholders[] = '$' . $i++;
        }

        $columnList = implode(', ', array_map([$this, 'qi'], $columns));
        $placeholderList = implode(', ', $placeholders);

        $sql = 'INSERT INTO ' . $this->qi($table) . " ({$columnList}) VALUES ({$placeholderList}) RETURNING " . $this->qi($this->primaryKey);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_values($data));

        $row = $stmt->fetch();
        return $row[$this->primaryKey] ?? $this->pdo->lastInsertId();
    }

    /** @inheritDoc */
    #[\Override]
    public function update(string $table, int|string $id, array $data): bool
    {
        $sets = [];
        $params = [];
        $i = 1;

        foreach ($data as $column => $value) {
            $sets[] = $this->qi($column) . ' = $' . $i++;
            $params[] = $value;
        }

        $params[] = $id;
        $setClause = implode(', ', $sets);

        $sql = 'UPDATE ' . $this->qi($table) . " SET {$setClause} WHERE " . $this->qi($this->primaryKey) . ' = $' . $i;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->rowCount() > 0;
    }

    /** @inheritDoc */
    #[\Override]
    public function delete(string $table, int|string $id): bool
    {
        $sql = 'DELETE FROM ' . $this->qi($table) . ' WHERE ' . $this->qi($this->primaryKey) . ' = $1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->rowCount() > 0;
    }

    /** @inheritDoc */
    #[\Override]
    public function transactional(callable $callback): mixed
    {
        $this->pdo->beginTransaction();
        try {
            $result = $callback();
            $this->pdo->commit();
            return $result;
        } catch (\Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    /** @inheritDoc */
    #[\Override]
    public function rawQuery(string $sql, array $params = []): array
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        if ($stmt->columnCount() > 0) {
            return $stmt->fetchAll();
        }
        return [];
    }

    /** @inheritDoc */
    #[\Override]
    public function exists(string $table, int|string $id): bool
    {
        $sql = 'SELECT 1 FROM ' . $this->qi($table) . ' WHERE ' . $this->qi($this->primaryKey) . ' = $1 LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetchColumn() !== false;
    }

    /** @inheritDoc */
    #[\Override]
    public function count(string $table, array $criteria = []): int
    {
        $sql = 'SELECT COUNT(*) FROM ' . $this->qi($table);
        $params = [];

        if (!empty($criteria)) {
            [$where, $params] = $this->buildWhere($criteria);
            $sql .= " WHERE {$where}";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return (int) $stmt->fetchColumn();
    }

    /**
     * Build WHERE clause with positional parameters.
     *
     * @return array{0: string, 1: array<mixed>}
     */
    private function buildWhere(array $criteria): array
    {
        $conditions = [];
        $params = [];
        $i = 1;

        foreach ($criteria as $column => $value) {
            if ($value === null) {
                $conditions[] = $this->qi($column) . ' IS NULL';
            } else {
                $conditions[] = $this->qi($column) . ' = $' . $i++;
                $params[] = $value;
            }
        }

        return [implode(' AND ', $conditions), $params];
    }

    /**
     * Quote Identifier — PostgreSQL uses double quotes.
     */
    private function qi(string $identifier): string
    {
        $clean = preg_replace('/[^a-zA-Z0-9_]/', '', $identifier);
        return '"' . $clean . '"';
    }
}
