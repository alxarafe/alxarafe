<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Models;

use Alxarafe\Core\Base\Table;

/**
 * Class Page
 *
 * @property int    $id
 * @property string $controller
 * @property string $title
 * @property string $description
 * @property string $menu
 * @property string $icon
 * @property int    $active
 * @property string $plugin
 * @property string $inserted_date
 * @property string $updated_date
 *
 * @package Alxarafe\Core\Models
 */
class Page extends Table
{
    /**
     * Page constructor.
     *
     * @param bool $create
     */
    public function __construct(bool $create = true)
    {
        parent::__construct(
            'pages',
            [
                'idField' => 'id',
                'nameField' => 'controller',
                'create' => $create,
            ]
        );
    }
}
