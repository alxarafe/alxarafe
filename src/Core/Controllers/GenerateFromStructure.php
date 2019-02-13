<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Controllers;

use Alxarafe\Base\PageController;
use Alxarafe\Helpers\Config;
use Alxarafe\Helpers\Skin;
use Alxarafe\Views\GenerateFromStructureView;

/**
 * Class for generate models and controllers from table structure.
 *
 * @package Alxarafe\Controllers
 */
class GenerateFromStructure extends PageController
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
     *
     * @return void
     */
    public function index(): void
    {
        parent::index();
        Skin::setView(new GenerateFromStructureView($this));
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

                break;
            case 'cancel':
                header('Location: ' . constant('BASE_URI'));
                break;
        }
    }

    /**
     * Run the class.
     *
     * @return void
     */
    public function run(): void
    {

    }

    /**.
     * Returns the page details.
     *
     * @return array
     */
    public function pageDetails(): array
    {
        $details = [
            'title' => Config::$lang->trans('generate-from-structure'),
            'icon' => '<span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span>',
            'description' => Config::$lang->trans('generate-from-estructure-description'),
            'menu' => 'dev-tools',
        ];
        return $details;
    }
}
