<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Modules\Sample\Controllers;

use Alxarafe\Core\Base\AuthPageExtendedController;
use Modules\Sample\Models\SampleComponent;

/**
 * Class SampleComponents
 *
 * @package Modules\Sample\Controllers
 */
class SampleComponents extends AuthPageExtendedController
{
    /**
     * Countries constructor.
     */
    public function __construct()
    {
        parent::__construct(new SampleComponent());
    }

    /**
     * Returns the page details.
     *
     * @return array
     */
    public function pageDetails(): array
    {
        $details = [
            'title' => 'controller-sample-components-title',
            'icon' => '<i class="fas fa-vial"></i>',
            'description' => 'controller-sample-components-description',
            'menu' => 'dev-tools',
        ];
        return $details;
    }
}
