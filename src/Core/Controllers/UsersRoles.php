<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Controllers;

use Alxarafe\Base\AuthPageExtendedController;
use Alxarafe\Models\UserRole;

/**
 * Class UsersRoles
 *
 * @package Alxarafe\Controllers
 */
class UsersRoles extends AuthPageExtendedController
{
    /**
     * UsersRoles constructor.
     */
    public function __construct()
    {
        parent::__construct(new UserRole());
    }

    /**
     * Returns the page details.
     *
     * @return array
     */
    public function pageDetails(): array
    {
        $details = [
            'title' => 'controller-users-roles-title',
            'icon' => '<i class="fas fa-users"></i>',
            'description' => 'controller-users-roles-description',
            'menu' => 'admin',
        ];
        return $details;
    }
}
