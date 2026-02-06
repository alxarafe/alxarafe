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

namespace Alxarafe\Base;

use Alxarafe\Base\Model\Model;

/**
 * Class Seeder.
 *
 * Abstract base for database seeders. Handles table truncation
 * and conditional execution.
 *
 * @package Alxarafe\Base
 */
abstract class Seeder
{
    /**
     * Initializes the seeder.
     *
     * @param bool $truncate If true, deletes all existing data in the table before running.
     */
    public function __construct(bool $truncate = false)
    {
        /** @var class-string<Model> $modelClass */
        $modelClass = static::model();

        if ($truncate) {
            $modelClass::truncate();
        }

        // Only runs if the table is empty to avoid duplicate records.
        if ($modelClass::count() === 0) {
            $this->run($modelClass);
        }
    }

    /**
     * Returns the Model class name associated with this seeder.
     * * @return class-string<Model>
     */
    abstract protected static function model(): string;

    /**
     * Logic to execute the seeding process.
     *
     * @param class-string<Model> $modelClass
     */
    abstract protected function run(string $modelClass): void;
}
