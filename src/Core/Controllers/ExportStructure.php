<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Controllers;

use Alxarafe\Base\PageController;
use Alxarafe\Helpers\Config;
use Alxarafe\Helpers\Schema;
use Alxarafe\Helpers\Skin;
use Alxarafe\Views\ExportStructureView;

/**
 * Controller for editing database and skin settings
 *
 * @package Alxarafe\Controllers
 */
class ExportStructure extends PageController
{

    /**
     * The constructor creates the view
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Start point
     */
    public function index()
    {
        parent::index();
        Skin::setView(new ExportStructureView($this));
    }

    /**
     * Main is invoked if method is not specified. Check if you have to save changes or just exit
     *
     * @return void
     */
    public function main(): void
    {
        switch (filter_input(INPUT_POST, 'action', FILTER_SANITIZE_ENCODED)) {
            case 'export-all':
                Schema::saveStructure();
                break;
            case 'export-selected':
                $tables = filter_input(INPUT_POST, 'tables', FILTER_SANITIZE_ENCODED, FILTER_REQUIRE_ARRAY);
                foreach ($tables as $table) {
                    Schema::saveTableStructure($table);
                }
                break;
            case 'cancel':
                header('Location: ' . constant('BASE_URI'));
                break;
        }
    }

    /**
     * Run the class.
     */
    public function run(): void
    {
        $this->index();
    }

    /**.
     * Returns the page details.
     */
    public function pageDetails()
    {
        $details = [
            'title' => Config::$lang->trans('export-db-estructure'),
            'icon' => '<span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span>',
            'description' => Config::$lang->trans('export-db-estructure-description'),
            'menu' => 'dev-tools',
        ];
        return $details;
    }
}
