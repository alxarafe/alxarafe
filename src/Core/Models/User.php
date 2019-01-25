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
class User extends Table
{
    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct(
            'users',
            [
                'idField' => 'id',
                'nameField' => 'username',
                'create' => true,
            ]
        );
    }
}
