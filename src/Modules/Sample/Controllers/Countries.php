<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Modules\Sample\Controllers;

use Alxarafe\Base\AuthPageExtendedController;
use Alxarafe\Modules\Sample\Models\Country;

/**
 * Class Countries
 *
 * @package Alxarafe\Modules\Sample\Controllers
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
            'icon' => '<span class="glyphicon glyphicon-user" aria-hidden="true"></span>',
            'description' => 'controller-countries-description',
            'menu' => 'regional-info',
        ];
        return $details;
    }
}
