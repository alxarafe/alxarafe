<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Controllers;

use Alxarafe\Base\CacheCore;
use Alxarafe\Base\PageController;
use Alxarafe\Helpers\Config;
use Alxarafe\Helpers\Debug;
use Alxarafe\Helpers\Skin;
use Alxarafe\Models\Page;
use Alxarafe\Views\EditConfigView;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

/**
 * Controller for editing database and skin settings.
 *
 * @package Alxarafe\Controllers
 */
class EditConfig extends PageController
{
    /**
     * @var array
     */
    protected $searchDir;
    /**
     * The constructor creates the view.
     */
    public function __construct()
    {
        parent::__construct();
        $this->searchDir = [
            'Alxarafe' => constant('ALXARAFE_FOLDER'),
            'Xfs' => constant('BASE_PATH'),
        ];
    }

    /**
     * Start point
     *
     * @return void
     */
    public function index(): void
    {
        parent::index();
        Skin::setView(new EditConfigView($this));
    }

    /**
     * Main is invoked if method is not specified. Check if you have to save changes or just exit.
     *
     * @return void
     */
    public function main(): void
    {
        $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_ENCODED);
        switch ($action) {
            case 'clear-cache':
                Config::$cacheEngine->clear();
                Config::setInfo('Cache cleared successfully.');
                break;
            case 'regenerate-data':
                Config::$cacheEngine->clear();
                Config::setInfo('Cache cleared successfully.');

                $this->regenerateData();
                break;
            case 'save':
                $msg = ($this->save() ? 'Changes stored' : 'Changes not stored');
                Debug::addMessage(
                    'messages',
                    $msg
                );
                Config::setInfo($msg);
                // The database or prefix may have been changed and have to be regenerated.
                Config::$cacheEngine->clear();
                $this->userAuth->logout();
                break;
            case 'cancel':
            default:
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
        $this->index();
    }

    /**
     * Save the form changes in the configuration file
     *
     * @return bool
     */
    private function save(): bool
    {
        $vars = [];
        $vars['dbEngineName'] = filter_input(INPUT_POST, 'dbEngineName', FILTER_SANITIZE_ENCODED);
        $vars['dbPrefix'] = filter_input(INPUT_POST, 'dbPrefix', FILTER_SANITIZE_ENCODED);
        $vars['skin'] = filter_input(INPUT_POST, 'skin', FILTER_SANITIZE_ENCODED);
        $vars['language'] = filter_input(INPUT_POST, 'language', FILTER_SANITIZE_ENCODED);
        $vars['dbUser'] = filter_input(INPUT_POST, 'dbUser', FILTER_SANITIZE_ENCODED);
        $vars['dbPass'] = filter_input(INPUT_POST, 'dbPass', FILTER_SANITIZE_ENCODED);
        $vars['dbName'] = filter_input(INPUT_POST, 'dbName', FILTER_SANITIZE_ENCODED);
        $vars['dbHost'] = filter_input(INPUT_POST, 'dbHost', FILTER_SANITIZE_ENCODED);
        $vars['dbPort'] = filter_input(INPUT_POST, 'dbPort', FILTER_SANITIZE_ENCODED);

        $yamlFile = Config::getConfigFileName();
        $yamlData = Yaml::dump($vars);
        return (bool) file_put_contents($yamlFile, $yamlData);
    }

    /**
     * Returns the page details.
     *
     * @return array
     */
    public function pageDetails(): array
    {
        $details = [
            'title' => Config::$lang->trans('edit-configuration'),
            'icon' => '<span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span>',
            'description' => Config::$lang->trans('edit-configuration-description'),
            //'menu' => 'admin|edit-config',
            'menu' => 'admin',
        ];
        return $details;
    }

    /**
     * Regenerate some needed data.
     *
     * @return void
     */
    private function regenerateData(): void
    {
        if (!set_time_limit(0)) {
            Config::setError('cant-increase-time-limit');
        }
        $this->instantiateModels();
        $this->checkPageControllers();
    }

    /**
     * Instantiate all available models
     *
     * TODO: This must be executed only when update/upgrade the core. At this moment is forced if DEBUG is enabled.
     *
     * @return void
     */
    private function instantiateModels(): void
    {
        // Start DB transaction
        Config::$dbEngine->beginTransaction();

        $loadedDep = [];
        $list = [];
        foreach ($this->searchDir as $namespace => $baseDir) {
            $models = Finder::create()
                ->files()
                ->name('*.php')
                ->in($dir = $baseDir . '/Models');
            foreach ($models->getIterator() as $modelFile) {
                $class = str_replace([$dir, '/', '\\', '.php'], ['', '', '', ''], $modelFile);
                $list[] = $namespace . '\\Models\\' . $class;
            }

            // Instanciate dependencies and after the main class
            foreach ($list as $class) {
                if (method_exists($class, 'getDependencies')) {
                    $deps = (new $class())->getDependencies();
                    foreach ($deps as $dep) {
                        if (!in_array($dep, $loadedDep)) {
                            $loadedDep[] = $dep;
                            new $dep(true);
                        }
                    }
                    if (!in_array($class, $loadedDep)) {
                        $loadedDep[] = $class;
                        new $class(true);
                    }
                }
            }
        }

        foreach ($list as $class) {
            if (!in_array($class, $loadedDep)) {
                $loadedDep[] = $class;
                new $class(true);
            }
        }

        // End DB transaction
        if (Config::$dbEngine->commit()) {
            Config::setInfo('Re-instanciated model class successfully');
        } else {
            Config::setError('Errors re-instanciating model class.');
        }
    }

    /**
     * Check all clases that extends from PageController, an store it to pages table.
     * We needed to generate the user menu.
     *
     * TODO: This must be checked only when update/upgrade the core.
     * WARNING: At this moment are generating 3 extra SQL queries per table.
     *
     * @return void
     */
    private function checkPageControllers(): void
    {
        // Start DB transaction
        Config::$dbEngine->beginTransaction();

        foreach ($this->searchDir as $namespace => $baseDir) {
            $controllers = Finder::create()
                ->files()
                ->name('*.php')
                ->in($dir = $baseDir . DIRECTORY_SEPARATOR . 'Controllers');
            foreach ($controllers as $controllerFile) {
                $className = str_replace([$dir . DIRECTORY_SEPARATOR, '.php'], ['', ''], $controllerFile);
                $class = '\\' . $namespace . '\\Controllers\\' . $className;
                $newClass = new $class();
                $parents = class_parents($class);
                if (in_array('Alxarafe\Base\PageController', $parents)) {
                    $this->updatePageData($className, $namespace, $newClass);
                }
            }
        }

        // End DB transaction
        if (Config::$dbEngine->commit()) {
            Config::setInfo('Re-instanciated page controller class successfully');
        } else {
            Config::setError('Errors re-instanciating page controller class.');
        }
    }

    /**
     * Updates the page data if needed.
     *
     * @param string $className
     * @param        $namespace
     * @param        $newPage
     */
    private function updatePageData(string $className, $namespace, $newPage)
    {
        $page = new Page();
        if (!$page->getBy('controller', $className)) {
            $page = new Page();
        }
        $page->controller = $className;
        $page->title = $newPage->title;
        $page->description = $newPage->description;
        $page->menu = $newPage->menu;
        $page->icon = $newPage->icon;
        $page->plugin = $namespace;
        $page->active = 1;
        $page->updated_date = date('Y-m-d H:i:s');
        $page->save();
    }
}
