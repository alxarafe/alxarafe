<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Models;

use Alxarafe\Base\Table;

/**
 * Class UserRoles. Link each user with the assigned roles.
 *
 * @property int $id
 * @property int $id_user
 * @property int $id_role
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
