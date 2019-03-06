<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Providers;

use Alxarafe\Core\Autoload\Load;
use Alxarafe\Core\Models\Module;
use Alxarafe\Core\PreProcessors;

/**
 * Class ModuleManager
 *
 * @package Alxarafe\Core\Providers
 */
class ModuleManager
{
    use Singleton {
        getInstance as getInstanceTrait;
    }

    /**
     * Contains all modules.
     *
     * @var array
     */
    protected static $modules;

    /**
     * Contains all enabled modules.
     *
     * @var array
     */
    protected static $enabledModules;

    /**
     * The translator manager.
     *
     * @var Translator
     */
    private static $translator;

    /**
     * Route to manage available routes.
     *
     * @var Router
     */
    private static $router;

    /**
     * Manage the renderer.
     *
     * @var TemplateRender
     */
    private static $renderer;

    /**
     * Module model to do queries.
     *
     * @var Module
     */
    private static $module;

    /**
     * Container constructor.
     */
    public function __construct()
    {
        if (!isset(self::$modules)) {
            $this->separateConfigFile = false;
            $this->initSingleton();
            self::$module = new Module();
            self::$modules = self::getModules();
            self::$enabledModules = self::getEnabledModules();
            self::$translator = Translator::getInstance();
            self::$router = Router::getInstance();
            self::$renderer = TemplateRender::getInstance();
        }
    }

    /**
     * Return the full modules.
     *
     * @return array
     */
    public static function getModules(): array
    {
        if (!isset(self::$modules)) {
            $modules = self::$module->getAllModules();
            foreach ($modules as $module) {
                self::$modules[$module['name']] = $module;
            }
        }
        return self::$modules;
    }

    /**
     * Return this instance.
     *
     * @return self
     */
    public static function getInstance(): self
    {
        return self::getInstanceTrait();
    }

    /**
     * Return default values
     *
     * @return array
     */
    public static function getDefaultValues(): array
    {
        // Not really needed
        return [];
    }

    /**
     * Returns the data from database.
     *
     * @return array
     */
    public function getConfig(): array
    {
        return self::getEnabledModules();
    }

    /**
     * Return a list of enabled modules.
     *
     * @return array
     */
    public static function getEnabledModules(): array
    {
        if (!isset(self::$enabledModules)) {
            $modules = self::$module->getEnabledModules();
            foreach ($modules as $module) {
                self::$enabledModules[$module['name']] = $module;
            }
        }
        return self::$enabledModules;
    }

    /**
     * Initialize modules.
     */
    public static function initializeModules(): void
    {
        // Add possible needed extra files
        self::addTranslatorFolders();
        self::addRenderFolders();

        self::runInitializer();
    }

    /**
     * Exec Initializer::init() from each enabled module.
     */
    private static function runInitializer()
    {
        $modules = self::getEnabledModules();
        $dirs = [];
        foreach ($modules as $module) {
            $dir = basePath($module['path']);
            $dirs[] = $dir;
            $initFile = $dir . DIRECTORY_SEPARATOR . 'Initializer.php';
            if (file_exists($initFile)) {
                $className = '\\Modules\\' . $module['name'] . '\\' . 'Initializer';
                $className::init();
                DebugTool::getInstance()->addMessage('messages', "{$className}::init()");
            }
        }
        // Add dirs for autoload
        Load::getInstance()::addDirs($dirs);
    }

    /**
     * Returns a list of folder from enabled modules.
     *
     * @return array
     */
    private static function getFoldersEnabledModules()
    {
        $folderList = [];
        foreach (self::$enabledModules as $module) {
            $folderList[] = $module['path'];
        }
        return $folderList;
    }

    /**
     * Adds enabled module folders to translator.
     */
    private static function addTranslatorFolders()
    {
        self::$translator->addDirs(self::getFoldersEnabledModules());
    }

    /**
     * Adds enabled module folders to renderer.
     */
    private static function addRenderFolders()
    {
        $list = [];
        foreach (self::getEnabledModules() as $module) {
            $list[] = [
                'name' => $module['name'],
                'path' => $module['path'],
            ];
        }
        self::$renderer->addDirs($list);
    }

    /**
     * Execute all preprocessors from one point.
     *
     * @param array $searchDir
     */
    public static function executePreprocesses(array $searchDir): void
    {
        if (!set_time_limit(0)) {
            FlashMessages::getInstance()::setError(Translator::getInstance()->trans('cant-increase-time-limit'));
        }

        $modules = self::getEnabledModules();
        foreach ($modules as $module) {
            if (is_dir($module['path'])) {
                $searchDir['Modules\\' . $module['name']] = $module['path'];
            } else {
                $module['enabled'] = 0;
                if ((new Module())->setData($module)->save()) {
                    FlashMessages::getInstance()::setWarning(Translator::getInstance()->trans('module-disable'));
                }
            }
        }
        new PreProcessors\Models($searchDir);
        new PreProcessors\Pages($searchDir);
        new PreProcessors\Routes($searchDir);
    }
}
