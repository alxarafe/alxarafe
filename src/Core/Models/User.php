<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Models;

use Alxarafe\Base\Table;

/**
 * Class Users
 *
 * @property int    $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $register_date
 * @property int    $active
 * @property string $logkey
 *
 * @package Alxarafe\Models
 */
class User extends Table
{
    /**
     * User constructor.
     *
     * @param bool $create
     */
    public function __construct(bool $create = true)
    {
        parent::__construct(
            'users',
            [
                'idField' => 'id',
                'nameField' => 'username',
                'create' => $create,
            ]
        );
    }
}
