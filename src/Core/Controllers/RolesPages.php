<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Controllers;

use Alxarafe\Base\AuthPageExtendedController;
use Alxarafe\Models\RolePage;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RolesPages
 *
 * @package Alxarafe\Controllers
 */
class RolesPages extends AuthPageExtendedController
{

    /**
     * RolesPages constructor.
     */
    public function __construct()
    {
        parent::__construct(new RolePage());
    }

    /**
     * Returns the page details.
     *
     * @return array
     */
    public function pageDetails(): array
    {
        $details = [
            'title' => 'controller-roles-pages-title',
            'icon' => '<span class="glyphicon glyphicon-equalizer" aria-hidden="true"></span>',
            'description' => 'controller-roles-pages-description',
            'menu' => 'admin',
        ];
        return $details;
    }
}
