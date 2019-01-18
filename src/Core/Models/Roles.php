<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Models;

use Alxarafe\Base\Table;

/**
 * Class Roles. Define the roles available in the application. By default, the administrator
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
     * Return a list of fields and their table structure.
     * Each final model that needed, must overwrite it.
     *
     * @return array
     */
    public function getFields(): array
    {
        return [
            'id' => [
                'label' => 'id',
                'type' => 'int',
                'key' => 'PRI',
                'extra' => 'auto_increment' // It is assumed to be the primary key
            ],
            'name' => [
                'label' => 'nombre',
                'type' => 'varchar',
            ],
            'active' => [
                'label' => 'activo',
                'type' => 'tinyint',
                'null' => 'YES',
                'default' => 0,
            ],
        ];
    }

    /**
     * TODO: Undocumented
     *
     * @return array
     */
    public function getKeys(): array
    {
        return [
            'role_name' => [
                'INDEX' => 'name',
            ],
        ];
    }

    /**
     * Return a list of default values.
     * Each final model that needed, must overwrite it.
     *
     * @return array
     */
    public function getDefaultValues(): array
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
