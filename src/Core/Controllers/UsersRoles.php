<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Controllers;

use Alxarafe\Base\Controller;
use Alxarafe\Base\View;
use Alxarafe\Models\UserRole;

/**
 * Class UsersRoles
 *
 * @package Alxarafe\Controllers
 */
class UsersRoles extends Controller
{

    /**
     * UsersRoles constructor.
     */
    public function __construct()
    {
        parent::__construct(new UserRole());
    }

    /**
     * The start point of the controller.
     *
     * @return void
     */
    public function run(): void
    {
        $this->setView(new View($this));
        parent::run();
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
            'icon' => '<span class="glyphicon glyphicon-user" aria-hidden="true"></span>',
            'description' => 'controller-users-roles-description',
            'menu' => 'admin',
        ];
        return $details;
    }
}
