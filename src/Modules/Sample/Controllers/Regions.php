<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Modules\Sample\Controllers;

use Alxarafe\Core\Base\AuthPageExtendedController;
use Modules\Sample\Models\Region;

/**
 * Class Regions
 *
 * @package Alxarafe\Modules\Sample\Controllers
 */
class Regions extends AuthPageExtendedController
{
    /**
     * Regions constructor.
     */
    public function __construct()
    {
        parent::__construct(new Region());
    }

    /**
     * Returns the page details.
     *
     * @return array
     */
    public function pageDetails(): array
    {
        $details = [
            'title' => 'controller-regions-title',
            'icon' => '<i class="fas fa-user"></i>',
            'description' => 'controller-regions-description',
            'menu' => 'regional-info',
        ];
        return $details;
    }
}
