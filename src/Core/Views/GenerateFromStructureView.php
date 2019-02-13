<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Views;

use Alxarafe\Base\View;
use Alxarafe\Helpers\Skin;

/**
 * Class GenerateFromStructureView
 *
 * @package Alxarafe\Views
 */
class GenerateFromStructureView extends View
{
    /**
     * GenerateFromStructureView constructor.
     *
     * @param $ctrl
     */
    public function __construct($ctrl)
    {
        Skin::setTemplate('generatefromstructure');

        parent::__construct($ctrl);
    }
}
