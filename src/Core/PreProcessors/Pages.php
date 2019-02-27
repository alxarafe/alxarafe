<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\PreProcessors;

use Alxarafe\Helpers\FormatUtils;
use Alxarafe\Models\Page;
use Alxarafe\Providers\Database;
use Alxarafe\Providers\FlashMessages;
use DateTime;
use Symfony\Component\Finder\Finder;

/**
 * This class pre-process pages to generate some needed information.
 *
 * @package Alxarafe\PreProcessors
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
    public function __construct(array $dirs)
    {
        $this->searchDir = $dirs;
        $this->checkPageControllers();
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
            $controllers = Finder::create()
                ->files()
                ->name('*.php')
                ->in($dir = $baseDir . DIRECTORY_SEPARATOR . 'Controllers');
            $start = new DateTime();
            foreach ($controllers as $controllerFile) {
                $className = str_replace([$dir . DIRECTORY_SEPARATOR, '.php'], ['', ''], $controllerFile);
                $this->instantiateClass($namespace, $className);
            }
            $this->cleanPagesBefore($start);
        }

        // End DB transaction
        if (Database::getInstance()->getDbEngine()->commit()) {
            FlashMessages::getInstance()::setInfo('Re-instanciated page controller class successfully');
        } else {
            FlashMessages::getInstance()::setError('Errors re-instanciating page controller class.');
        }
    }

    /**
     * Instanciate class and update page data if needed.
     *
     * @param string $namespace
     * @param string $className
     */
    private function instantiateClass(string $namespace, string $className)
    {
        $class = '\\' . $namespace . '\\Controllers\\' . $className;
        $newClass = new $class();
        $parents = class_parents($class);
        if (in_array('Alxarafe\Base\AuthPageController', $parents)) {
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
    private function updatePageData(string $className, string $namespace, $newPage)
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

    /**
     * Clean all pages before $start datetime.
     *
     * @param DateTime $start
     */
    private function cleanPagesBefore(DateTime $start)
    {
        $pages = (new Page())->getAllRecords();
        foreach ($pages as $oldPage) {
            $updatedDate = new DateTime($oldPage['updated_date'] . '.999999');
            if ($start->diff($updatedDate)->f < 0) {
                $page = new Page();
                $page->setOldData($oldPage);
                $page->delete();
            }
        }
    }
}
