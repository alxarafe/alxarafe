<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Models;

use Alxarafe\Core\Base\Table;

/**
 * Class Role. Define the roles available in the application. By default, the administrator
 * and the user are defined.
 *
 * @property int    $id
 * @property string $name
 * @property int    $active
 * @property int    $locked
 *
 * @package Alxarafe\Core\Models
 */
class Role extends Table
{
    /**
     * Role constructor.
     *
     * @param bool $create
     */
    public function __construct(bool $create = true)
    {
        parent::__construct(
            'roles',
            [
                'idField' => 'id',
                'nameField' => 'name',
                'create' => $create,
            ]
        );
    }
}
