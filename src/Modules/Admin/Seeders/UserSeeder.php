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

namespace Modules\Admin\Seeders;

use Alxarafe\Infrastructure\Persistence\Model\Model;
use Alxarafe\Infrastructure\Persistence\Seeder;
use Modules\Admin\Model\User;

class UserSeeder extends Seeder
{
    /**
     * Returns the name of the seeder table.
     */

    /**
     * Auto generated seed file
     *
     * @return void
     * @psalm-suppress UndefinedConstant
     */
    protected function run($modelClass): void
    {
        $password = 'password';
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $modelClass::create([
            'name' => 'admin',
            'email' => 'admin@alxarafe.com',
            'password' => $hashedPassword,
            'is_admin' => true,
        ]);

        $modelClass::create([
            'name' => 'user',
            'email' => 'user@alxarafe.com',
            'password' => $hashedPassword,
        ]);

        $modelClass::create([
            'name' => 'tester',
            'email' => 'tester@alxarafe.com',
            'password' => $hashedPassword,
        ]);

        $modelClass::create([
            'name' => 'gestor',
            'email' => 'gestor@alxarafe.com',
            'password' => $hashedPassword,
        ]);

        $modelClass::create([
            'name' => 'auditor',
            'email' => 'auditor@alxarafe.com',
            'password' => $hashedPassword,
        ]);
    }

    protected static function model(): string
    {
        return User::class;
    }
}
