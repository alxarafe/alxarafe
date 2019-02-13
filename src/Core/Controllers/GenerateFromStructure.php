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
use Alxarafe\Models\TableModel;
use Alxarafe\Views\GenerateFromStructureView;
use Symfony\Component\Finder\Finder;

/**
 * Class for generate models and controllers from table structure.
 *
 * @package Alxarafe\Controllers
 */
class GenerateFromStructure extends PageController
{
    public $tables;

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

        $this->loadDefaultData();
    }

    /**
     * Main is invoked if method is not specified. Check if you have to save changes or just exit
     *
     * @return void
     */
    public function main(): void
    {
        switch (filter_input(INPUT_POST, 'action', FILTER_SANITIZE_ENCODED)) {
            case 'generate-all':
                //Schema::loadDataFromYaml();
                break;
            case 'generate-for-table':
                //Schema::loadDataFromYaml();
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
            'description' => Config::$lang->trans('generate-from-structure-description'),
            'menu' => 'dev-tools',
        ];
        return $details;
    }

    /**
     * Load default data for this controller.
     */
    private function loadDefaultData()
    {
        $dirs = [
            'Xfs' => constant('BASE_PATH') . DIRECTORY_SEPARATOR . 'config/schema',
        ];

        $this->tables = [];
        // Load all files from schema folder
        foreach ($dirs as $namespace => $baseDir) {
            $models = Finder::create()
                ->files()
                ->name('*.yaml')
                ->in($baseDir);
            foreach ($models->getIterator() as $modelFile) {
                $fileName = str_replace('.yaml', '', $modelFile->getFilename());
                $this->tables[$fileName] = $modelFile->getPathname();
            }
        }

        // Exclude all files that are already in use (don't need to be generated)
        foreach ((new TableModel())->getAllRecords() as $pos => $data) {
            if (array_key_exists($data['tablename'], $this->tables)) {
                unset($this->tables[$data['tablename']]);
            }
        }
    }
}
