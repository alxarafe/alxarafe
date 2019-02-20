<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
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
     * Array that contains the paths to search.
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
            $this->fillList($namespace, $baseDir, $list);

            // Instanciate dependencies and after the main class
            foreach ($list as $class) {
                $this->loadClassDependencies($loadedDep, $class);
            }
        }

        foreach ($list as $class) {
            $this->loadClassIfNeeded($loadedDep, $class);
        }

        // End DB transaction
        if (Config::$dbEngine->commit()) {
            Config::setInfo('Re-instanciated model class successfully');
        } else {
            Config::setError('Errors re-instanciating model class.');
        }
    }

    /**
     * Fill list of classes.
     *
     * @param string $namespace
     * @param string $baseDir
     * @param string[]  $list
     */
    private function fillList(string $namespace, string $baseDir, array &$list)
    {
        $models = Finder::create()
            ->files()
            ->name('*.php')
            ->in($dir = $baseDir . '/Models');
        foreach ($models->getIterator() as $modelFile) {
            $class = str_replace([$dir, '/', '\\', '.php'], ['', '', '', ''], $modelFile);
            $list[] = $namespace . '\\Models\\' . $class;
        }
    }

    /**
     * Load class dependencies before load direct class.
     *
     * @param array  $loadedDep
     * @param string $class
     */
    private function loadClassDependencies(array &$loadedDep, string $class)
    {
        if (method_exists($class, 'getDependencies')) {
            $deps = (new $class())->getDependencies();
            foreach ($deps as $dep) {
                $this->loadClassIfNeeded($loadedDep, $dep);
            }
            $this->loadClassIfNeeded($loadedDep, (string) $class);
        }
    }

    /**
     * Load class only if not yet loaded.
     *
     * @param array  $loadedDep
     * @param string $class
     */
    private function loadClassIfNeeded(array &$loadedDep, string $class)
    {
        if (!in_array($class, $loadedDep)) {
            $loadedDep[] = $class;
            new $class(true);
        }
    }
}
