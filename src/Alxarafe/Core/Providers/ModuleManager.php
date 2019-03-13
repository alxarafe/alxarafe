<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Providers;

use Alxarafe\Core\Autoload\Load;
use Alxarafe\Core\Base\CacheCore;
use Alxarafe\Core\Helpers\FormatUtils;
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
     * Return the full modules from database.
     *
     * @return array
     */
    public static function getModules(): array
    {
        self::$modules = [];
        foreach (self::$module->getAllModules() as $module) {
            self::$modules[$module['name']] = $module;
        }
        return self::$modules;
    }

    /**
     * Return a list of enabled modules from database.
     *
     * @return array
     */
    public static function getEnabledModules(): array
    {
        self::$enabledModules = [];
        foreach (self::$module->getEnabledModules() as $module) {
            self::$enabledModules[$module['name']] = $module;
        }
        return self::$enabledModules;
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
     * Adds enabled module folders to translator.
     */
    private static function addTranslatorFolders(): void
    {
        self::$translator->addDirs(self::getFoldersEnabledModules());
    }

    /**
     * Returns a list of folder from enabled modules.
     *
     * @return array
     */
    private static function getFoldersEnabledModules(): array
    {
        $folderList = [];
        foreach (self::$enabledModules as $module) {
            $folderList[] = $module['path'];
        }
        return $folderList;
    }

    /**
     * Adds enabled module folders to renderer.
     */
    private static function addRenderFolders(): void
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
     * Exec Initializer::init() from each enabled module.
     */
    private static function runInitializer(): void
    {
        $dirs = [];
        foreach (self::getEnabledModules() as $module) {
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
     * Execute all preprocessors from one point.
     */
    public static function executePreprocesses(): void
    {
        if (!set_time_limit(0)) {
            FlashMessages::getInstance()::setError(self::$translator->trans('cant-increase-time-limit'));
        }

        foreach (self::getEnabledModules() as $module) {
            if (!is_dir($module['path'])) {
                $module['enabled'] = null;
                if ((new Module())->setData($module)->save()) {
                    FlashMessages::getInstance()::setWarning(self::$translator->trans('module-disable'));
                }
            }
        }

        self::runPreprocessors();
    }

    /**
     * Run preprocessors for update modules dependencies.
     */
    public static function runPreprocessors(): void
    {
        CacheCore::getInstance()->getEngine()->clear();
        $enabledFolders = self::getEnabledFolders();
        new PreProcessors\Models($enabledFolders);
        new PreProcessors\Pages($enabledFolders);
        new PreProcessors\Routes($enabledFolders);
        FlashMessages::getInstance()::setInfo(self::$translator->trans('preprocessors-executed'));
    }

    /**
     * Return a list of enabled folders.
     *
     * @return array
     */
    public static function getEnabledFolders(): array
    {
        $searchDir = [];
        $searchDir['Alxarafe\\Core'] = constant('ALXARAFE_FOLDER');
        foreach (self::getEnabledModules() as $enabledModule) {
            $searchDir['Modules\\' . $enabledModule['name']] = basePath($enabledModule['path']);
        }
        return $searchDir;
    }

    /**
     * Enable a module.
     *
     * @param string $name
     *
     * @return bool
     */
    public static function enableModule(string $name): bool
    {
        $status = false;
        $module = new Module();
        if ($module->getBy('name', $name)) {
            $module->enabled = FormatUtils::getFormatted(FormatUtils::getFormatDateTime());
            $module->updated_date = FormatUtils::getFormatted(FormatUtils::getFormatDateTime());
            if ($status = $module->save()) {
                FlashMessages::getInstance()::setSuccess(
                    self::$translator->trans('module-enabled', ['%moduleName%' => $name])
                );
                self::runPreprocessors();
            }
        }
        return $status;
    }

    /**
     * Disable a module.
     *
     * @param string $name
     *
     * @return bool
     */
    public static function disableModule(string $name): bool
    {
        $status = false;
        $module = new Module();
        if ($module->getBy('name', $name)) {
            $module->enabled = null;
            $module->updated_date = FormatUtils::getFormatted(FormatUtils::getFormatDateTime());
            if ($status = $module->save()) {
                FlashMessages::getInstance()::setSuccess(
                    self::$translator->trans('module-disabled', ['%moduleName%' => $name])
                );
                self::runPreprocessors();
            }
        }
        return $status;
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
}
