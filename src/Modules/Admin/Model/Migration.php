<?php

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
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

namespace CoreModules\Admin\Model;

use Alxarafe\Base\Model\Model;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

/**
 * The "migrations" table contains the list of updates to the database tables.
 */
final class Migration extends Model
{
    protected $table = 'migrations';
    protected $fillable = ['migration', 'batch'];

    public static function getLastBatch()
    {
        $instance = new self();

        if (!Capsule::schema()->hasTable($instance->getTable())) {
            self::createTable();
        }

        return self::max('batch') ?? 0;
    }

    /**
     * Create the migration table if it does not exist.
     *
     * @return void
     */
    private static function createTable()
    {
        Capsule::schema()->create('migrations', function (Blueprint $table) {
            $table->id();
            $table->string('migration');
            $table->integer('batch')->unsigned();
            $table->timestamps();
        });
    }

    public function exists($exists = false): bool
    {
        if (!Capsule::schema()->hasTable($this->getTable())) {
            self::createTable();
            return false;
        }
        return $this->newQuery()->exists();
    }
}
