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
class Role extends Table
{
    /**
     * Roles constructor.
     */
    public function __construct()
    {
        parent::__construct(
            'roles',
            [
                'idField' => 'id',
                'nameField' => 'name',
                'create' => true,
            ]
        );
    }
}
