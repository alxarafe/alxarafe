<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Models;

use Alxarafe\Base\Table;

/**
 * Class Users
 *
 * @package Alxarafe\Models
 */
class Users extends Table
{

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct('users', [
            'idField' => 'id',
            'nameField' => 'username',
            'create' => true,
        ]);
    }

    /**
     * Return a list of fields and their table structure.
     * Each final model that needed, must overwrite it.
     *
     * @return array
     */
    /*
    public function getFields(): array
    {
        return [
            'id' => [
                'label' => 'id',
                'type' => 'integer',
                'extra' => 'auto_increment' // It is assumed to be the primary key
            ],
            'username' => [
                'label' => 'username',
                'type' => 'varchar',
            ],
            'email' => [
                'label' => 'email',
                'type' => 'varchar',
            ],
            'password' => [
                'label' => 'password',
                'type' => 'varchar',
            ],
            'register_date' => [
                'label' => 'Fecha de registro',
                'type' => 'timestamp',
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'active' => [
                'label' => 'Activo',
                'type' => 'tinyint',
                'null' => 'YES',
                'default' => 0,
            ],
        ];
    }
    */

    /**
     * TODO: Undocumented
     *
     * @return array
     */
    /*
    public function getKeys(): array
    {
        return [
            'user_name' => [
                'INDEX' => 'username',
            ],
        ];
    }
    */

    /**
     * Return a list of default values.
     * Each final model that needed, must overwrite it.
     *
     * @return array
     */
    /*
    public function getDefaultValues(): array
    {
        return [
            [
                'id' => 1,
                'username' => 'admin',
                'email' => 'admin@alxarafe.com',
                'password' => password_hash('admin', PASSWORD_DEFAULT),
                'active' => 1,
            ],
            [
                'id' => 2,
                'username' => 'user',
                'email' => 'user@alxarafe.com',
                'password' => password_hash('user', PASSWORD_DEFAULT),
                'active' => 1,
            ],
        ];
    }
    */
}
