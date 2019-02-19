<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Controllers;

use Alxarafe\Base\PageController;
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
     * ExportStructure constructor.
     */
    public function __construct()
    {
        parent::__construct();
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
                header('Location: ' . constant('BASE_URI') . '/index.php');
                break;
        }
    }

    /**
     * The start point of the controller.
     *
     * @return void
     */
    public function run(): void
    {
        $this->index();
    }

    /**
     * Start point
     *
     * @return void
     */
    public function index(): void
    {
        parent::index();
        Skin::setView(new ExportStructureView($this));
    }

    /**.
     * Returns the page details.
     *
     * @return array
     */
    public function pageDetails(): array
    {
        $details = [
            'title' => 'export-db-estructure',
            'icon' => '<span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span>',
            'description' => 'export-db-estructure-description',
            'menu' => 'dev-tools',
        ];
        return $details;
    }
}
