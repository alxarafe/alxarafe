<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Modules\Sample\Controllers;

use Alxarafe\Core\Base\AuthPageExtendedController;
use Modules\Sample\Models\Person;

/**
 * Class People
 *
 * @package Alxarafe\Modules\Sample\Controllers
 */
class People extends AuthPageExtendedController
{
    /**
     * People constructor.
     */
    public function __construct()
    {
        parent::__construct(new Person());
    }

    /**
     * Returns the page details.
     *
     * @return array
     */
    public function pageDetails(): array
    {
        $details = [
            'title' => 'controller-people-title',
            'icon' => '<i class="fas fa-user"></i>',
            'description' => 'controller-people-description',
            'menu' => 'default',
        ];
        return $details;
    }
}
