<?php
/**
 * Created by PhpStorm.
 * User: shawe
 * Date: 14/02/19
 * Time: 15:45
 */

namespace Alxarafe\PreProcessors;

use Alxarafe\Helpers\Config;
use Alxarafe\Models\Page;
use Symfony\Component\Finder\Finder;

/**
 * This class pre-process pages to generate some needed information.
 *
 * @package Alxarafe\PreProcessors
 */
class Pages
{
    /**
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
     *
     * @return void
     */
    private function checkPageControllers(): void
    {
        // Start DB transaction
        Config::$dbEngine->beginTransaction();

        $pages = (new Page())->getAllRecords();
        foreach ($pages as $pos => $oldPage) {
            $page = new Page();
            $page->setOldData($oldPage);
            $page->delete();
        }

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