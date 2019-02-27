<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Controllers;

use Alxarafe\Base\AuthPageExtendedController;
use Alxarafe\Models\Role;

/**
 * Class Roles
 *
 * @package Alxarafe\Controllers
 */
class Roles extends AuthPageExtendedController
{
    /**
     * Roles constructor.
     */
    public function __construct()
    {
        parent::__construct(new Role());
    }

    /**
     * Returns the page details.
     *
     * @return array
     */
    public function pageDetails(): array
    {
        $details = [
            'title' => 'controller-roles-title',
            'icon' => '<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>',
            'description' => 'controller-roles-description',
            'menu' => 'admin',
        ];
        return $details;
    }
}
