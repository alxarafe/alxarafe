<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Controllers;

use Alxarafe\Base\AuthPageExtendedController;
use Alxarafe\Models\TableModel;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Models
 *
 * @package Alxarafe\Controllers
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
            'icon' => '<span class="glyphicon glyphicon-list" aria-hidden="true"></span>',
            'description' => 'controller-tables-description',
            'menu' => 'dev-tools',
        ];
        return $details;
    }
}
