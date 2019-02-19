<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Controllers;

use Alxarafe\Base\Controller;
use Alxarafe\Base\View;
use Alxarafe\Models\RolePage;

/**
 * Class RolesPages
 *
 * @package Alxarafe\Controllers
 */
class RolesPages extends Controller
{

    /**
     * RolesPages constructor.
     */
    public function __construct()
    {
        parent::__construct(new RolePage());
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
            'title' => 'controller-roles-pages-title',
            'icon' => '<span class="glyphicon glyphicon-equalizer" aria-hidden="true"></span>',
            'description' => 'controller-roles-pages-description',
            'menu' => 'admin',
        ];
        return $details;
    }
}
