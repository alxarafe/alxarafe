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
        parent::__construct('users', ['create' => true]);
    }

    /**
     * TODO: Undocumented
     */
    public function getFields()
    {
        return [
            'id' => array(
                'label' => 'id',
                'type' => 'int',
                'extra' => 'auto_increment' // It is assumed to be the primary key
            ),
            'username' => array(
                'label' => 'username',
                'type' => 'varchar'
            ),
            'email' => array(
                'label' => 'email',
                'type' => 'varchar'
            ),
            'password' => array(
                'label' => 'password',
                'type' => 'varchar'
            ),
            'register_date' => array(
                'label' => 'Fecha de registro',
                'type' => 'timestamp',
                'default' => 'CURRENT_TIMESTAMP'
            ),
            'active' => array(
                'label' => 'Activo',
                'type' => 'tinyint',
                'null' => 'YES',
                'default' => 0
            ),
        ];
    }

    /**
     * TODO: Undocumented
     *
     * @return array
     */
    public function getKeys()
    {
        return [
            'user_name' => [
                'INDEX' => 'username',
            ],
        ];
    }

    /**
     * TODO: Undocumented
     *
     * @return array
     */
    public function getDefaultValues()
    {
        return [
            [
                'id' => 1,
                'username' => 'admin',
                'email' => 'admin@alxarafe.com',
                'password' => md5('admin'),
                'active' => 1,
            ],
            [
                'id' => 2,
                'username' => 'user',
                'email' => 'user@alxarafe.com',
                'password' => md5('user'),
                'active' => 1,
            ],
        ];
    }
}
