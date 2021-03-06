<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\PreProcessors;

use Alxarafe\Core\Base\AuthPageController;
use Alxarafe\Core\Helpers\FormatUtils;
use Alxarafe\Core\Helpers\Utils\FileSystemUtils;
use Alxarafe\Core\Models\Page;
use Alxarafe\Core\Providers\Database;
use Alxarafe\Core\Providers\FlashMessages;
use Alxarafe\Core\Providers\Translator;
use Symfony\Component\Finder\Finder;

/**
 * This class pre-process pages to generate some needed information.
 *
 * @package Alxarafe\Core\PreProcessors
 */
class Pages
{
    /**
     * Array that contains the paths to find the Controllers folder that contains the controllers
     *
     * @var array
     */
    protected $searchDir;

    /**
     * Models constructor.
     *
     * @param array $dirs
     */
    public function __construct(array $dirs = [])
    {
        $this->searchDir = $dirs;
        $this->updatePageDetails();
        $this->checkPageControllers();
    }

    /**
     * Updates active page field based on enabled namespaces
     */
    private function updatePageDetails()
    {
        $page = new Page();
        $allPages = $page->getAllRecords();
        foreach ($allPages as $pageData) {
            if (!$page->get($pageData['id'])) {
                continue;
            }
            $page->active = 0;
            if (array_key_exists($page->plugin, $this->searchDir)) {
                $page->active = 1;
            }
            $page->save();
        }
    }

    /**
     * Check all clases that extends from PageController, an store it to pages table.
     * We needed to generate the user menu.
     *
     * TODO: This must be checked only when update/upgrade the core.
     * WARNING: At this moment are generating 3 extra SQL queries per table.
     */
    private function checkPageControllers(): void
    {
        // Start DB transaction
        Database::getInstance()->getDbEngine()->beginTransaction();

        foreach ($this->searchDir as $namespace => $baseDir) {
            $dir = $baseDir . DIRECTORY_SEPARATOR . 'Controllers';
            FileSystemUtils::mkdir($dir, 0777, true);
            $controllers = Finder::create()
                ->files()
                ->name('*.php')
                ->in($dir)
                ->notName('index.php');
            foreach ($controllers as $controllerFile) {
                $className = str_replace([$dir . DIRECTORY_SEPARATOR, '.php'], '', $controllerFile);
                $this->instantiateClass($namespace, $className);
            }
        }

        // End DB transaction
        if (!Database::getInstance()->getDbEngine()->commit()) {
            FlashMessages::getInstance()::setError(Translator::getInstance()->trans('reinstanciated-controller-class-for-pages-error'));
        }
    }

    /**
     * Instanciate class and update page data if needed.
     *
     * @param string $namespace
     * @param string $className
     */
    private function instantiateClass(string $namespace, string $className): void
    {
        if ($namespace === 'Alxarafe') {
            $namespace .= '\\Core';
        }
        $class = '\\' . $namespace . '\\Controllers\\' . $className;
        $newClass = new $class();
        $parents = class_parents($class);
        if (in_array(AuthPageController::class, $parents, true)) {
            $this->updatePageData($className, $namespace, $newClass);
        }
    }

    /**
     * Updates the page data if needed.
     *
     * @param string $className
     * @param string $namespace
     * @param        $newPage
     */
    private function updatePageData(string $className, string $namespace, $newPage): void
    {
        $page = new Page();
        $page->getBy('controller', $className);
        $page->controller = $className;
        $page->title = $newPage->title;
        $page->description = $newPage->description;
        $page->menu = $newPage->menu;
        $page->icon = $newPage->icon;
        $page->plugin = $namespace;
        $page->active = 1;
        $page->updated_date = FormatUtils::getFormattedDateTime();
        $page->save();
    }
}
