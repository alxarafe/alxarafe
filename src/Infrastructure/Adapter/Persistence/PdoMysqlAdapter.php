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
use PDOException;

/**
 * PdoMysqlAdapter — MySQL persistence adapter using PDO.
 *
 * Pure PDO implementation without Eloquent dependencies.
 * This is the recommended adapter for new hexagonal applications.
 *
 * @package Alxarafe\Infrastructure\Adapter\Persistence
 */
class PdoMysqlAdapter implements PersistencePort
{
    private PDO $pdo;
    private string $primaryKey;

    /**
     * @param string $host     Database host.
     * @param string $dbName   Database name.
     * @param string $username Database user.
     * @param string $password Database password.
     * @param int    $port     Database port (default: 3306).
     * @param string $charset  Character set (default: utf8mb4).
     * @param string $primaryKey Default primary key column name (default: 'id').
     */
    public function __construct(
        string $host,
        string $dbName,
        string $username,
        string $password,
        int $port = 3306,
        string $charset = 'utf8mb4',
        string $primaryKey = 'id'
    ) {
        $dsn = "mysql:host={$host};port={$port};dbname={$dbName};charset={$charset}";

        $this->pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);

        $this->primaryKey = $primaryKey;
    }

    /**
     * Alternative constructor from a configuration object.
     *
     * @param \stdClass $config Config with properties: host, name, user, pass, port, charset.
     * @param string    $primaryKey Default primary key column.
     *
     * @return self
     */
    public static function fromConfig(\stdClass $config, string $primaryKey = 'id'): self
    {
        return new self(
            host: $config->host ?? 'localhost',
            dbName: $config->name,
            username: $config->user,
            password: $config->pass,
            port: (int) ($config->port ?? 3306),
            charset: $config->charset ?? 'utf8mb4',
            primaryKey: $primaryKey
        );
    }

    /**
     * Get the underlying PDO instance (for edge cases and migrations).
     */
    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    /** @inheritDoc */
    #[\Override]
    public function findById(string $table, int|string $id): ?array
    {
        $sql = "SELECT * FROM `{$this->sanitizeIdentifier($table)}` WHERE `{$this->primaryKey}` = ? LIMIT 1";
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
        $table = $this->sanitizeIdentifier($table);
        $sql = "SELECT * FROM `{$table}`";
        $params = [];

        if (!empty($criteria)) {
            [$where, $params] = $this->buildWhere($criteria);
            $sql .= " WHERE {$where}";
        }

        if (!empty($orderBy)) {
            $orders = [];
            foreach ($orderBy as $column => $direction) {
                $col = $this->sanitizeIdentifier($column);
                $dir = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';
                $orders[] = "`{$col}` {$dir}";
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
        $table = $this->sanitizeIdentifier($table);
        $columns = array_keys($data);
        $placeholders = array_fill(0, count($columns), '?');

        $columnList = implode('`, `', array_map([$this, 'sanitizeIdentifier'], $columns));
        $placeholderList = implode(', ', $placeholders);

        $sql = "INSERT INTO `{$table}` (`{$columnList}`) VALUES ({$placeholderList})";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_values($data));

        return $this->pdo->lastInsertId();
    }

    /** @inheritDoc */
    #[\Override]
    public function update(string $table, int|string $id, array $data): bool
    {
        $table = $this->sanitizeIdentifier($table);
        $sets = [];
        $params = [];

        foreach ($data as $column => $value) {
            $sets[] = "`{$this->sanitizeIdentifier($column)}` = ?";
            $params[] = $value;
        }

        $params[] = $id;
        $setClause = implode(', ', $sets);

        $sql = "UPDATE `{$table}` SET {$setClause} WHERE `{$this->primaryKey}` = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->rowCount() > 0;
    }

    /** @inheritDoc */
    #[\Override]
    public function delete(string $table, int|string $id): bool
    {
        $table = $this->sanitizeIdentifier($table);
        $sql = "DELETE FROM `{$table}` WHERE `{$this->primaryKey}` = ?";
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

        // For SELECT queries, return results; for others return empty array
        if ($stmt->columnCount() > 0) {
            return $stmt->fetchAll();
        }

        return [];
    }

    /** @inheritDoc */
    #[\Override]
    public function exists(string $table, int|string $id): bool
    {
        $table = $this->sanitizeIdentifier($table);
        $sql = "SELECT 1 FROM `{$table}` WHERE `{$this->primaryKey}` = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetchColumn() !== false;
    }

    /** @inheritDoc */
    #[\Override]
    public function count(string $table, array $criteria = []): int
    {
        $table = $this->sanitizeIdentifier($table);
        $sql = "SELECT COUNT(*) FROM `{$table}`";
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
     * Build a WHERE clause from criteria.
     *
     * @param array<string, mixed> $criteria
     *
     * @return array{0: string, 1: array<mixed>} [whereClause, params]
     */
    private function buildWhere(array $criteria): array
    {
        $conditions = [];
        $params = [];

        foreach ($criteria as $column => $value) {
            $col = $this->sanitizeIdentifier($column);
            if ($value === null) {
                $conditions[] = "`{$col}` IS NULL";
            } else {
                $conditions[] = "`{$col}` = ?";
                $params[] = $value;
            }
        }

        return [implode(' AND ', $conditions), $params];
    }

    /**
     * Sanitize a SQL identifier (table or column name) to prevent injection.
     */
    private function sanitizeIdentifier(string $identifier): string
    {
        return preg_replace('/[^a-zA-Z0-9_]/', '', $identifier) ?? $identifier;
    }
}
