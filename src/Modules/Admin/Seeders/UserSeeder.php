<?php

namespace CoreModules\Admin\Seeders;

use Alxarafe\Base\Model\Model;
use Alxarafe\Base\Seeder;
use CoreModules\Admin\Model\User;

class UserSeeder extends Seeder
{
    /**
     * Returns the name of the seeder table.
     */

    protected static function model(): Model
    {
        return new User();
    }

    /**
     * Auto generated seed file
     *
     * @return void
     */
    protected function run($model): void
    {
        $password = 'password';
        $hashedPassword = sodium_crypto_pwhash_str(
            $password,
            SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
            SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE
        );

        $model::create([
            'name' => 'admin',
            'email' => 'admin@mycompany.com',
            'password' => $hashedPassword,
            'is_admin' => true,
        ]);

        $model::create([
            'name' => 'user',
            'email' => 'user@mycompany.com',
            'password' => $hashedPassword,
        ]);
    }
}
