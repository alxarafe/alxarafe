<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Controllers;

use Alxarafe\Base\Controller;
use Alxarafe\Base\View;
use Alxarafe\Models\Role;
use Alxarafe\Providers\Container;

/**
 * Class Roles
 *
 * @package Alxarafe\Controllers
 */
class Roles extends Controller
{

    /**
     * Roles constructor.
     *
     * @param Container|null $container
     */
    public function __construct(Container $container = null)
    {
        parent::__construct($container, new Role());
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
            'title' => 'controller-roles-title',
            'icon' => '<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>',
            'description' => 'controller-roles-description',
            'menu' => 'admin',
        ];
        return $details;
    }
}
