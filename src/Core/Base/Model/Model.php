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

namespace Alxarafe\Base\Model;

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Base Model class extending Eloquent.
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Query\Builder
 */
abstract class Model extends EloquentModel
{
    /**
     * Checks if the table associated with the model exists in the database.
     */
    public function existsInSchema(): bool
    {
        $tableName = $this->getTable();
        return !empty($tableName) && DB::schema()->hasTable($tableName);
    }

    /**
     * Returns the primary key column name.
     */
    public function primaryColumn(): string
    {
        return $this->getKeyName();
    }

    /**
     * Get field metadata from the database schema.
     *
     * @return array<string, array>
     */
    public static function getFields(): array
    {
        /** @phpstan-ignore-next-line */
        $instance = new static();
        $table = $instance->getTable();
        $connection = $instance->getConnection();
        $fullTable = $connection->getTablePrefix() . $table;
        $schema = DB::schema();

        if (!$schema->hasTable($table)) {
            return [];
        }

        /** @phpstan-ignore-next-line */
        $columns = DB::select("SHOW COLUMNS FROM `{$fullTable}`");
        $fields = [];

        foreach ($columns as $column) {
            $columnName = (string) $column->Field;
            $dbType = (string) $column->Type;
            $nullable = $column->Null === 'YES';
            $default = $column->Default;

            // Extract length/values if present using modern preg_match
            $length = null;
            if (preg_match('/\((.*)\)/', $dbType, $matches)) {
                $length = $matches[1];
            }

            $fields[$columnName] = [
                'field' => $columnName,
                'label' => ucfirst(str_replace('_', ' ', $columnName)),
                'genericType' => self::mapToGenericType($dbType),
                'dbType' => $dbType,
                'required' => !$nullable && $default === null && $column->Key !== 'PRI' && $column->Extra !== 'auto_increment',
                'length' => is_numeric($length) ? (int) $length : $length,
                'nullable' => $nullable,
                'default' => $default,
            ];
        }

        return $fields;
    }

    /**
     * Maps database types to generic types used for UI generation.
     */
    protected static function mapToGenericType(string $dbType): string
    {
        $dbType = strtolower($dbType);

        return match (true) {
            str_contains($dbType, 'bool') || str_contains($dbType, 'tinyint') => 'boolean', // Covers tinyint(1), tinyint(4), etc.
            str_contains($dbType, 'int') => 'integer',
            str_contains($dbType, 'decimal') || str_contains($dbType, 'float') || str_contains($dbType, 'double') => 'decimal',
            str_contains($dbType, 'datetime') || str_contains($dbType, 'timestamp') => 'datetime',
            str_contains($dbType, 'date') => 'date',
            str_contains($dbType, 'time') => 'time',
            str_contains($dbType, 'text') || str_contains($dbType, 'blob') => 'textarea',
            default => 'text',
        };
    }
}
