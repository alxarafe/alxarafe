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
class UserRole extends Table
{
    /**
     * UserRole constructor.
     *
     * @param bool $create
     */
    public function __construct(bool $create = true)
    {
        parent::__construct(
            'user_roles',
            [
                'idField' => 'id',
                'nameField' => 'id',
                'create' => $create,
            ]
        );
    }
}
