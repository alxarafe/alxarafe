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
use Alxarafe\Helpers\Utils;
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
    /**
     * List of available table schema.
     *
     * @var array
     */
    public $tables;

    /**
     * The table name.
     *
     * @var string
     */
    public $tableName;

    /**
     * @var
     */
    public $tableSchema;

    /**
     * The full path from schema table file.
     *
     * @var string
     */
    public $fileName;

    /**
     * The name to use to generate the model.
     *
     * @var string
     */
    public $modelName;

    /**
     * The name to use to generate the controller.
     *
     * @var string
     */
    public $controllerName;

    /**
     * List of model dependencies.
     *
     * @var array
     */
    public $modelDeps;

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
        $this->tableName = filter_input(INPUT_POST, 'table', FILTER_SANITIZE_STRING);
        $this->fileName = filter_input(INPUT_POST, 'file', FILTER_SANITIZE_STRING);
        $this->modelName = filter_input(INPUT_POST, 'model', FILTER_SANITIZE_STRING);
        $this->controllerName = filter_input(INPUT_POST, 'controller', FILTER_SANITIZE_STRING);

        switch (filter_input(INPUT_POST, 'action', FILTER_SANITIZE_ENCODED)) {
            case 'generate-model':
                $this->tableSchema = Schema::loadDataFromYaml($this->fileName);
                $this->modelDeps = [];
                foreach ($this->tableSchema['indexes'] as $key => $details) {
                    if (isset($details['referencedtable'])) {
                        $this->modelDeps[] = 'Xfs\\Models\\' . Utils::snakeToCamel($details['referencedtable']);
                    }
                }
                Skin::setTemplate('code/xfsmodel.php');
                break;
            case 'generate-controller':
                $this->tableSchema = Schema::loadDataFromYaml($this->fileName);
                Skin::setTemplate('code/xfscontroller.php');
                break;
            case 'cancel':
                header('Location: ' . constant('BASE_URI') . '/index.php');
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
            'title' => 'generate-from-structure',
            'icon' => '<span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span>',
            'description' => 'generate-from-structure-description',
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
