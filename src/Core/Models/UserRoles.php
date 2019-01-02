<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Models;

use Alxarafe\Base\Table;

/**
 * TODO:
 *
 * Link each user with the assigned roles.
 *
 * @package Alxarafe\Models
 */
class UserRoles extends Table
{

    /**
     * UserRoles constructor.
     */
    public function __construct()
    {
        parent::__construct('user_roles', ['create' => true]);
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return [
            'user_id' => array(
                'type' => 'int',
            ),
            'role_id' => array(
                'type' => 'int',
            ),
        ];
    }

    /**
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
     * @return array
     */
    public function getDefaultValues()
    {
        return [
            [
                'user_id' => 1,
                'role_id' => 1,
            ],
        ];
    }
}
