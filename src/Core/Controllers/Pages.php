<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Controllers;

use Alxarafe\Models\Page;
use Alxarafe\Base\Controller;
use Alxarafe\Base\View;
use Alxarafe\Providers\Container;

/**
 * Class Pages
 *
 * @package Alxarafe\Controllers
 */
class Pages extends Controller
{

    /**
     * Pages constructor.
     */
    public function __construct()
    {
        parent::__construct(new Page());
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
            'title' => 'controller-pages-title',
            'icon' => '<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>',
            'description' => 'controller-pages-description',
            'menu' => 'admin',
        ];
        return $details;
    }
}
