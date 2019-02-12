<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Models;

use Alxarafe\Base\Table;

/**
 * Class RolePage. Link each role with the assigned page.
 *
 * @package Alxarafe\Models
 */
class RolePage extends Table
{
    /**
     * RolePage constructor.
     *
     * @param bool $create
     */
    public function __construct(bool $create = true)
    {
        parent::__construct(
            'roles_pages',
            [
                'idField' => 'id',
                'nameField' => 'id',
                'create' => $create,
            ]
        );
    }
}
