<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Modules\Sample\Controllers;

use Alxarafe\Core\Base\AuthPageExtendedController;
use Modules\Sample\Models\Subregion;

/**
 * Class Subregions
 *
 * @package Modules\Sample\Controllers
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
