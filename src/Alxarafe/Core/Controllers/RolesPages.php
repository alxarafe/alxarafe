<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Controllers;

use Alxarafe\Core\Base\AuthPageExtendedController;
use Alxarafe\Core\Models\Page;
use Alxarafe\Core\Models\Role;
use Alxarafe\Core\Models\RolePage;

/**
 * Class RolesPages
 *
 * @package Alxarafe\Core\Controllers
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
            'icon' => '<i class="fas fa-users-cog"></i>',
            'description' => 'controller-roles-pages-description',
            'menu' => 'admin',
        ];
        return $details;
    }

    /**
     * Return class dependencies
     *
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [
            Page::class,
            Role::class,
        ];
    }
}
