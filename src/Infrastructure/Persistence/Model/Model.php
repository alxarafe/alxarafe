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

namespace Alxarafe\Infrastructure\Persistence\Model;

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

            // 1. Enrich with auto-detected numeric limits
            $limits = self::computeNumericLimits($dbType);
            $fields[$columnName] = array_merge($fields[$columnName], $limits);
        }

        // 2. Merge business rules (tighter constraints win)
        $rules = static::fieldRules();
        foreach ($rules as $fieldName => $overrides) {
            if (!isset($fields[$fieldName])) {
                continue;
            }
            foreach ($overrides as $key => $value) {
                if ($key === 'min' && isset($fields[$fieldName]['min'])) {
                    // Business min can only be MORE restrictive
                    $fields[$fieldName]['min'] = max($value, $fields[$fieldName]['min']);
                } elseif ($key === 'max' && isset($fields[$fieldName]['max'])) {
                    // Business max can only be MORE restrictive
                    $fields[$fieldName]['max'] = min($value, $fields[$fieldName]['max']);
                } else {
                    $fields[$fieldName][$key] = $value;
                }
            }
        }

        return $fields;
    }

    /**
     * Return business-level field constraints.
     * Override in concrete models to declare tighter rules.
     *
     * @return array<string, array<string, mixed>>
     * Example: ['age' => ['min' => 1, 'max' => 10], 'name' => ['maxlength' => 50]]
     */
    public static function fieldRules(): array
    {
        return [];
    }

    /**
     * Validate data against field metadata + business rules.
     * Returns array of error messages (empty = valid).
     */
    public static function validateData(array $data): array
    {
        $fields = static::getFields();
        $errors = [];

        foreach ($fields as $fieldName => $meta) {
            $value = $data[$fieldName] ?? null;

            // Required
            if (($meta['required'] ?? false) && ($value === null || $value === '')) {
                $errors[] = "Field '{$fieldName}' is required.";
                continue;
            }

            if ($value === null || $value === '') {
                continue;
            }

            // Numeric range
            if (isset($meta['min']) && is_numeric($value) && $value < $meta['min']) {
                $errors[] = "Field '{$fieldName}': {$value} < min ({$meta['min']}).";
            }
            if (isset($meta['max']) && is_numeric($value) && $value > $meta['max']) {
                $errors[] = "Field '{$fieldName}': {$value} > max ({$meta['max']}).";
            }

            // String length
            if (isset($meta['maxlength']) && is_string($value) && mb_strlen((string)$value) > $meta['maxlength']) {
                $errors[] = "Field '{$fieldName}': length > {$meta['maxlength']}.";
            }
        }

        return $errors;
    }

    /**
     * Computes numeric limits based on the database column type.
     */
    protected static function computeNumericLimits(string $dbType): array
    {
        $t = strtolower($dbType);
        $unsigned = str_contains($t, 'unsigned');

        // Integer types
        $intRanges = [
            'tinyint'   => ['signed' => [-128, 127],           'unsigned' => [0, 255]],
            'smallint'  => ['signed' => [-32768, 32767],        'unsigned' => [0, 65535]],
            'mediumint' => ['signed' => [-8388608, 8388607],    'unsigned' => [0, 16777215]],
            'bigint'    => ['signed' => [PHP_INT_MIN, PHP_INT_MAX], 'unsigned' => [0, PHP_INT_MAX]],
            'int'       => ['signed' => [-2147483648, 2147483647], 'unsigned' => [0, 4294967295]],
        ];

        foreach ($intRanges as $type => $ranges) {
            if (str_contains($t, $type)) {
                $range = $unsigned ? $ranges['unsigned'] : $ranges['signed'];
                return ['min' => $range[0], 'max' => $range[1], 'step' => 1, 'unsigned' => $unsigned];
            }
        }

        // Decimal types: decimal(10,2) → precision=10, scale=2
        if (preg_match('/(?:decimal|numeric)\((\d+),(\d+)\)/', $t, $m)) {
            $precision = (int) $m[1];
            $scale = (int) $m[2];
            $maxVal = (float) (str_repeat('9', $precision - $scale) . '.' . str_repeat('9', $scale));
            $minVal = $unsigned ? 0 : -$maxVal;
            $step = $scale > 0 ? (float) ('0.' . str_repeat('0', $scale - 1) . '1') : 1;
            return ['min' => $minVal, 'max' => $maxVal, 'step' => $step,
                    'precision' => $precision, 'scale' => $scale, 'unsigned' => $unsigned];
        }

        // Float/double — no hard DB limits in this simple calculation
        if (str_contains($t, 'float') || str_contains($t, 'double')) {
            return ['unsigned' => $unsigned];
        }

        return [];
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
