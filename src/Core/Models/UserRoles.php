<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Models;

use Alxarafe\Base\Table;

/**
 * Class UserRoles. Link each user with the assigned roles.
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
     * Return a list of fields and their table structure.
     * Each final model that needed, must overwrite it.
     *
     * @return array
     */
    public function getFields(): array
    {
        return [
            'user_id' => [
                'type' => 'int',
            ],
            'role_id' => [
                'type' => 'int',
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
                'user_id' => 1,
                'role_id' => 1,
            ],
        ];
    }
}
