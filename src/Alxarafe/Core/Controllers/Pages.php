<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Controllers;

use Alxarafe\Core\Base\AuthPageExtendedController;
use Alxarafe\Core\Models\Page;

/**
 * Class Pages
 *
 * @package Alxarafe\Core\Controllers
 */
class Pages extends AuthPageExtendedController
{
    /**
     * Pages constructor.
     */
    public function __construct()
    {
        parent::__construct(new Page());
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
            'icon' => '<i class="fas fa-list-alt"></i>',
            'description' => 'controller-pages-description',
            'menu' => 'admin',
        ];
        return $details;
    }
}
