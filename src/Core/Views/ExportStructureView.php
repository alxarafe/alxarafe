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
     * TODO: Undocumented
     *
     * @var array
     */
    public $dbEngines;

    /**
     * TODO: Undocumented
     *
     * @var mixed|string
     */
    public $dbEngineName;

    /**
     * TODO: Undocumented
     *
     * @var array
     */
    public $skins;

    /**
     * TODO: Undocumented
     *
     * @var
     */
    public $skin;

    /**
     * TODO: Undocumented
     *
     * @var
     */
    public $dbConfig;

    /**
     * ExportStructureView constructor.
     *
     * @param $ctrl
     */
    public function __construct($ctrl)
    {
        Skin::setTemplate('exportstructure');

        parent::__construct($ctrl);
    }
}
