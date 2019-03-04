<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Models;

use Alxarafe\Core\Base\Table;

/**
 * Class RolePage. Link each role with the assigned page.
 *
 * @property int $id
 * @property int $id_role
 * @property int $id_page
 * @property int $can_access
 * @property int $can_create
 * @property int $can_read
 * @property int $can_update
 * @property int $can_delete
 * @property int $locked
 *
 * @package Alxarafe\Core\Models
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
