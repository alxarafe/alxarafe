<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\PreProcessors;

use Alxarafe\Core\Base\Controller;
use Alxarafe\Core\Providers\Database;
use Alxarafe\Core\Providers\FlashMessages;
use Alxarafe\Core\Providers\Router;
use Alxarafe\Core\Providers\Translator;
use Symfony\Component\Finder\Finder;

/**
 * This class pre-process pages to generate some needed information.
 *
 * @package Alxarafe\Core\PreProcessors
 */
class Routes
{
    /**
     * Array that contains the paths to find the Controllers folder that contains the controllers
     *
     * @var array
     */
    protected $searchDir;

    /**
     * Route to manage available routes.
     *
     * @var Router
     */
    private $router;

    /**
     * Models constructor.
     *
     * @param array $dirs
     */
    public function __construct(array $dirs)
    {
        $this->searchDir = $dirs;
        $this->checkRoutesControllers();
    }

    /**
     * Check all clases that extends from PageController, an store it to pages table.
     * We needed to generate the user menu.
     *
     * TODO: This must be checked only when update/upgrade the core.
     * WARNING: At this moment are generating 3 extra SQL queries per table.
     */
    private function checkRoutesControllers(): void
    {
        // Start DB transaction
        Database::getInstance()->getDbEngine()->beginTransaction();

        $this->router = Router::getInstance();
        // Delete all routes
        $this->router->setRoutes($this->router::getDefaultValues());
        foreach ($this->searchDir as $namespace => $baseDir) {
            $dir = $baseDir . DIRECTORY_SEPARATOR . 'Controllers';
            $controllers = Finder::create()
                ->files()
                ->name('*.php')
                ->in($dir);
            foreach ($controllers as $controllerFile) {
                if (array_key_exists($namespace, $this->searchDir)) {
                    $className = str_replace([$dir . DIRECTORY_SEPARATOR, '.php'], '', $controllerFile);
                    $this->instantiateClass($namespace, $className);
                }
            }
        }
        $this->router->saveRoutes();

        // End DB transaction
        if (!Database::getInstance()->getDbEngine()->commit()) {
            FlashMessages::getInstance()::setError(Translator::getInstance()->trans('reinstanciated-controller-class-for-routes-error'));
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
        $parents = class_parents($class);
        if (in_array(Controller::class, $parents, true)) {
            $this->router->addRoute($className, $class, true);
        }
    }
}
