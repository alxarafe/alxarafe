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

namespace CoreModules\Admin\Seeders;

use Alxarafe\Base\Model\Model;
use Alxarafe\Base\Seeder;
use CoreModules\Admin\Model\User;

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
    #[\Override]
    protected function run($modelClass): void
    {
        $password = 'password';
        $hashedPassword = sodium_crypto_pwhash_str(
            $password,
            SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
            SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE
        );

        $modelClass::create([
            'name' => 'admin',
            'email' => 'admin@mycompany.com',
            'password' => $hashedPassword,
            'is_admin' => true,
        ]);

        $modelClass::create([
            'name' => 'user',
            'email' => 'user@mycompany.com',
            'password' => $hashedPassword,
        ]);
    }

    #[\Override]
    protected static function model(): string
    {
        return User::class;
    }
}
