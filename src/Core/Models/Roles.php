<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Models;

use Alxarafe\Base\Table;

/**
 * TODO: Undocumented
 *
 * Define the roles available in the application. By default, the administrator
 * and the user are defined.
 *
 * @package Alxarafe\Models
 */
class Roles extends Table
{

    /**
     * Roles constructor.
     */
    public function __construct()
    {
        parent::__construct('roles', ['create' => true]);
    }

    /**
     * TODO: Undocumented
     *
     * @return array
     */
    public function getFields()
    {
        return [
            'id' => array(
                'label' => 'id',
                'type' => 'int',
                'key' => 'PRI',
                'extra' => 'auto_increment' // It is assumed to be the primary key
            ),
            'name' => array(
                'label' => 'nombre',
                'type' => 'varchar'
            ),
            'active' => array(
                'label' => 'activo',
                'type' => 'tinyint',
                'null' => 'YES',
                'default' => 0,
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
            'role_name' => [
                'INDEX' => 'name',
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
                'name' => "'Administrator'",
                'active' => 1,
            ],
            [
                'id' => 2,
                'username' => "'User'",
                'active' => 1,
            ],
        ];
    }
}
