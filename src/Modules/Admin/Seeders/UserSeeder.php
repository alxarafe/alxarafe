<?php

namespace CoreModules\Admin\Seeders;

use Alxarafe\Base\Controller\ApiController;
use Alxarafe\Base\Seeder;
use Alxarafe\Lib\Auth;
use CoreModules\Admin\Model\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Returns the name of the seeder table.
     */

    protected static function model()
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
            'is_admin' => 1,
        ]);

        $model::create([
            'name' => 'user',
            'email' => 'user@mycompany.com',
            'password' => $hashedPassword,
        ]);
    }
}
