<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Modules\Sample\Controllers;

use Alxarafe\Base\AuthPageExtendedController;
use Alxarafe\Modules\Sample\Models\Subregion;

/**
 * Class Subregions
 *
 * @package Alxarafe\Modules\Sample\Controllers
 */
class Subregions extends AuthPageExtendedController
{
    /**
     * Subregions constructor.
     */
    public function __construct()
    {
        parent::__construct(new Subregion());
    }

    /**
     * Returns the page details.
     *
     * @return array
     */
    public function pageDetails(): array
    {
        $details = [
            'title' => 'controller-subregions-title',
            'icon' => '<i class="fas fa-user"></i>',
            'description' => 'controller-subregions-description',
            'menu' => 'regional-info',
        ];
        return $details;
    }
}
