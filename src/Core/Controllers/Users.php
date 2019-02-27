<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Controllers;

use Alxarafe\Base\AuthPageExtendedController;
use Alxarafe\Models\User;

/**
 * Class Users
 *
 * @package Alxarafe\Controllers
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
            'icon' => '<span class="glyphicon glyphicon-user" aria-hidden="true"></span>',
            'description' => 'controller-users-description',
            'menu' => 'admin',
        ];
        return $details;
    }
}
