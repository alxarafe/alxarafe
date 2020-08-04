<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Controllers;

use Alxarafe\Core\Base\AuthPageExtendedController;
use Alxarafe\Core\Models\Role;

/**
 * Class Roles
 *
 * @package Alxarafe\Core\Controllers
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
            'icon' => '<i class="fas fa-cogs"></i>',
            'description' => 'controller-roles-description',
            'menu' => 'admin',
        ];
        return $details;
    }
}
