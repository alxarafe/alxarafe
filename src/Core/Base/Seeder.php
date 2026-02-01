<?php

/* Copyright (C) 2024      Rafael San José      <rsanjose@alxarafe.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace Alxarafe\Base;

use Alxarafe\Base\Model\Model;

/**
 * Create a PDO database connection
 *
 * @package Alxarafe\Base
 */
abstract class Seeder
{
    public function __construct($truncate = false)
    {
        /** @var class-string<Model> $model */
        $model = static::model();

        if ($truncate) {
            $model::truncate();
        }

        if ($model::count() === 0) {
            $this->run($model);
        }
    }

    /**
     * Returns the name of the seeder table.
     * @return class-string<Model>
     */
    abstract protected static function model(): string;

    /**
     * Execute the seeder
     *
     * @param string $model
     * @return void
     */
    abstract protected function run(string $model): void;
}
