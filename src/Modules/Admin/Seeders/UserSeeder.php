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

    /**
     * Auto generated seed file
     *
     * @return void
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
