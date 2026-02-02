<?php

namespace Alxarafe\Base\Model;

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Query\Builder
 */
abstract class Model extends EloquentModel
{
    public function exists(): bool
    {
        $table_name = $this->getTable();
        if (empty($table_name)) {
            return false;
        }
        return DB::schema()->hasTable($table_name);
    }

    public function primaryColumn(): string
    {
        return $this->getKeyName();
    }

    /**
     * Get field metadata from the database schema.
     *
     * @return array
     */
    public static function getFields(): array
    {
        $instance = new static();
        $table = $instance->getTable();
        $schema = DB::schema();

        if (!$schema->hasTable($table)) {
            return [];
        }

        $columns = DB::select("SHOW COLUMNS FROM `{$table}`");
        $fields = [];

        foreach ($columns as $column) {
            $columnName = $column->Field;
            $dbType = $column->Type;
            $nullable = $column->Null === 'YES';
            $default = $column->Default;
            
            // Extract length/values if present
            $length = null;
            if (preg_match('/\((.*)\)/', $dbType, $matches)) {
                $length = $matches[1];
            }

            $fields[$columnName] = [
                'field' => $columnName,
                'label' => ucfirst(str_replace('_', ' ', $columnName)),
                'generictype' => self::mapToGenericType($dbType),
                'db_type' => $dbType,
                'required' => !$nullable && $default === null && $column->Key !== 'PRI' && $column->Extra !== 'auto_increment',
                'length' => is_numeric($length) ? (int)$length : $length,
                'nullable' => $nullable,
                'default' => $default,
            ];
        }

        return $fields;
    }

    /**
     * Maps database types to generic types used by ResourceController.
     *
     * @param string $dbType
     * @return string
     */
    protected static function mapToGenericType(string $dbType): string
    {
        $dbType = strtolower($dbType);
        if (str_contains($dbType, 'bool')) return 'boolean';
        if (str_contains($dbType, 'int')) return 'number';
        if (str_contains($dbType, 'decimal') || str_contains($dbType, 'float') || str_contains($dbType, 'double')) return 'number';
        if (str_contains($dbType, 'date')) {
            return str_contains($dbType, 'time') ? 'datetime' : 'date';
        }
        if (str_contains($dbType, 'text') || str_contains($dbType, 'blob')) return 'textarea';
        
        return 'text';
    }
}
