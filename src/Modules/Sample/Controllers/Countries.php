<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Modules\Sample\Controllers;

use Alxarafe\Core\Base\AuthPageExtendedController;
use Modules\Sample\Models\Country;

/**
 * Class Countries
 *
 * @package Modules\Sample\Controllers
 */
class Countries extends AuthPageExtendedController
{
    /**
     * Countries constructor.
     */
    public function __construct()
    {
        parent::__construct(new Country());
    }

    /**
     * Returns the page details.
     *
     * @return array
     */
    public function pageDetails(): array
    {
        $details = [
            'title' => 'controller-countries-title',
            'icon' => '<i class="fas fa-user"></i>',
            'description' => 'controller-countries-description',
            'menu' => 'regional-info',
        ];
        return $details;
    }
}
