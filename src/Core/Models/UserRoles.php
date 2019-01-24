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
        parent::__construct(
            'user_roles',
            [
                'idField' => 'id',
                'nameField' => 'id',
                'create' => true,
            ]
        );
    }
}
