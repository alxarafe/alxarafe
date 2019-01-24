<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Models;

use Alxarafe\Base\Table;

/**
 * Class Page
 *
 * @package Alxarafe\Models
 */
class Page extends Table
{
    /**
     * Page constructor.
     */
    public function __construct()
    {
        parent::__construct(
            'pages',
            [
                'idField' => 'id',
                'nameField' => 'controller',
                'create' => true,
            ]
        );
    }
}
