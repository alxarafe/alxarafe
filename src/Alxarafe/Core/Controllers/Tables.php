<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Controllers;

use Alxarafe\Core\Base\AuthPageExtendedController;
use Alxarafe\Core\Models\TableModel;

/**
 * Class Models
 *
 * @package Alxarafe\Core\Controllers
 */
class Tables extends AuthPageExtendedController
{
    /**
     * Tables constructor.
     */
    public function __construct()
    {
        parent::__construct(new TableModel());
    }

    /**
     * Returns the page details.
     *
     * @return array
     */
    public function pageDetails(): array
    {
        $details = [
            'title' => 'controller-tables-title',
            'icon' => '<i class="fas fa-list"></i>',
            'description' => 'controller-tables-description',
            'menu' => 'dev-tools',
        ];
        return $details;
    }
}
