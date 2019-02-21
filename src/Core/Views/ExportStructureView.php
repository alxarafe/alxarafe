<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Views;

use Alxarafe\Base\View;
use Alxarafe\Helpers\Skin;
use Alxarafe\Providers\Database;

/**
 * Class ExportStructureView
 *
 * @package Alxarafe\Views
 */
class ExportStructureView extends View
{
    /**
     * Lits of available tables.
     *
     * @var array
     */
    public $tables;

    /**
     * ExportStructureView constructor.
     *
     * @param $ctrl
     */
    public function __construct($ctrl)
    {
        parent::__construct($ctrl);
        Skin::setTemplate('exportstructure');

        $this->tables = Database::getInstance()->getSqlHelper()->getTables();
    }
}
