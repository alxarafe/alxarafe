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
    public static function exists(): bool
    {
        $instance = new static();
        $table_name = $instance->table;
        if (empty($table_name)) {
            return false;
        }
        return DB::schema()->hasTable($table_name);
    }
}
