<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Modules\Sample\Controllers;

use Alxarafe\Core\Base\AuthPageExtendedController;
use Modules\Sample\Models\IntermediateRegion;

/**
 * Class IntermediateRegions
 *
 * @package Modules\Sample\Controllers
 */
class IntermediateRegions extends AuthPageExtendedController
{
    /**
     * IntermediateRegions constructor.
     */
    public function __construct()
    {
        parent::__construct(new IntermediateRegion());
    }

    /**
     * Returns the page details.
     *
     * @return array
     */
    public function pageDetails(): array
    {
        $details = [
            'title' => 'controller-intermediate-regions-title',
            'icon' => '<i class="fas fa-user"></i>',
            'description' => 'controller-intermediate-regions-description',
            'menu' => 'regional-info',
        ];
        return $details;
    }
}
