<?php

namespace CoreModules\Admin\Seeders;

use Alxarafe\Base\Seeder;
use CoreModules\Admin\Model\User;

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
        $model::create([
            'name' => 'admin',
            'email' => 'admin@mycompany.com',
            'password' => 'password',
            'is_admin' => 1,
        ]);

        $model::create([
            'name' => 'user',
            'email' => 'user@mycompany.com',
            'password' => 'password',
        ]);
    }
}
