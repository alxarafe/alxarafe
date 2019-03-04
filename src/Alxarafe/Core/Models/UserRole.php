<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Models;

use Alxarafe\Core\Base\Table;

/**
 * Class UserRoles. Link each user with the assigned roles.
 *
 * @property int $id
 * @property int $id_user
 * @property int $id_role
 *
 * @package Alxarafe\Core\Models
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
