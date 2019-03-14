<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\PreProcessors;

use Alxarafe\Core\Helpers\Utils\FileSystemUtils;
use Alxarafe\Core\Models\TableModel;
use Alxarafe\Core\Providers\Database;
use Alxarafe\Core\Providers\FlashMessages;
use Alxarafe\Core\Providers\Translator;
use ReflectionClass;
use Symfony\Component\Finder\Finder;

/**
 * This class pre-process Models to generate some needed information.
 *
 * @package Alxarafe\Core\PreProcessors
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
        Database::getInstance()->getDbEngine()->beginTransaction();

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
        if (!Database::getInstance()->getDbEngine()->commit()) {
            FlashMessages::getInstance()::setError(Translator::getInstance()->trans('reinstanciated-model-class-error'));
        }
    }

    /**
     * Fill list of classes.
     *
     * @param string   $namespace
     * @param string   $baseDir
     * @param string[] $list
     */
    private function fillList(string $namespace, string $baseDir, array &$list): void
    {
        $dir = $baseDir . DIRECTORY_SEPARATOR . 'Models';
        FileSystemUtils::mkdir($dir, 0777, true);
        $models = Finder::create()
            ->files()
            ->name('*.php')
            ->in($dir);
        foreach ($models->getIterator() as $modelFile) {
            $class = str_replace([$dir, '/', '\\', '.php'], '', $modelFile);
            if ($namespace === 'Alxarafe') {
                $namespace .= '\\Core';
            }
            $list[] = $namespace . '\\Models\\' . $class;
        }
    }

    /**
     * Load class dependencies before load direct class.
     *
     * @param array  $loadedDep
     * @param string $class
     */
    private function loadClassDependencies(array &$loadedDep, string $class): void
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
    private function loadClassIfNeeded(array &$loadedDep, string $className): void
    {
        if (!in_array($className, $loadedDep, true)) {
            $loadedDep[] = $className;
            $class = new $className(true);

            if ($class->modelName !== 'TableModel') {
                $tableModel = new TableModel();
                if (!$tableModel->load($class->tableName)) {
                    $tableModel->tablename = $class->tableName;
                    $tableModel->model = $class->modelName;
                    try {
                        $tableModel->namespace = (new ReflectionClass($class))->getName();
                    } catch (\ReflectionException $e) {
                        $tableModel->namespace = static::class;
                    }
                    $tableModel->save();
                }
            }
        }
    }
}
