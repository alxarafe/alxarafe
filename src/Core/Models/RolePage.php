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
     */
    public function __construct()
    {
        parent::__construct(
            'roles_pages',
            [
                'idField' => 'id',
                'nameField' => 'id',
                'create' => true,
            ]
        );
    }
}
