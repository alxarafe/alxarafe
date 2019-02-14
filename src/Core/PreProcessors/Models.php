<?php
/**
 * Created by PhpStorm.
 * User: shawe
 * Date: 14/02/19
 * Time: 15:45
 */

namespace Alxarafe\PreProcessors;

use Alxarafe\Helpers\Config;
use Symfony\Component\Finder\Finder;

/**
 * This class pre-process Models to generate some needed information.
 *
 * @package Alxarafe\PreProcessors
 */
class Models
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
        $this->instantiateModels();
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
}