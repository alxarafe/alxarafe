<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Views;

use Alxarafe\Base\View;
use Alxarafe\Helpers\Skin;

/**
 * Class ExportStructureView
 *
 * @package Alxarafe\Views
 */
class ExportStructureView extends View
{

    /**
     * ExportStructureView constructor.
     *
     * @param $ctrl
     */
    public function __construct($ctrl)
    {
        parent::__construct($ctrl);
        Skin::setTemplate('exportstructure');
    }
}
