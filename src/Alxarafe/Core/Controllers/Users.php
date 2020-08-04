<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Controllers;

use Alxarafe\Core\Base\AuthPageExtendedController;
use Alxarafe\Core\Models\User;

/**
 * Class Users
 *
 * @package Alxarafe\Core\Controllers
 */
class Users extends AuthPageExtendedController
{
    /**
     * Users constructor.
     */
    public function __construct()
    {
        parent::__construct(new User());
    }

    /**
     * Returns the page details.
     *
     * @return array
     */
    public function pageDetails(): array
    {
        $details = [
            'title' => 'controller-users-title',
            'icon' => '<i class="fas fa-user"></i>',
            'description' => 'controller-users-description',
            'menu' => 'admin',
        ];
        return $details;
    }
}
