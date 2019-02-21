<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Views;

use Alxarafe\Base\View;

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
        $this->renderer->setTemplate('generatefromstructure');

        parent::__construct($ctrl);
    }
}
