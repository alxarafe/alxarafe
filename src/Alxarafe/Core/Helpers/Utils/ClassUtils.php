<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Helpers\Utils;

use Alxarafe\Core\Models\Module;
use Alxarafe\Core\PreProcessors;
use Alxarafe\Core\Providers\FlashMessages;
use Alxarafe\Core\Providers\Logger;
use Alxarafe\Core\Providers\Translator;
use ReflectionClass;
use ReflectionException;

/**
 * Class ClassUtils
 *
 * @package Alxarafe\Core\Helpers
 */
class ClassUtils
{
    /**
     * Define a constant if it does not exist
     *
     * @param string $const
     * @param        $value
     */
    public static function defineIfNotExists(string $const, $value): void
    {
        if (!defined($const)) {
            define($const, $value);
        }
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

        $modules = (new Module())->getEnabledModules();
        foreach ($modules as $module) {
            if (is_dir($module->path)) {
                $searchDir['Modules\\' . $module->name] = $module->path;
            } else {
                $module->enabled = 0;
                if ($module->save()) {
                    FlashMessages::getInstance()::setWarning(Translator::getInstance()->trans('module-disable'));
                }
            }
        }
        new PreProcessors\Models($searchDir);
        new PreProcessors\Pages($searchDir);
        new PreProcessors\Routes($searchDir);
    }

    /**
     * Returns the short name of the class.
     *
     * @param $objectClass
     * @param $calledClass
     *
     * @return string
     */
    public static function getShortName($objectClass, $calledClass): string
    {
        try {
            $shortName = (new ReflectionClass($objectClass))->getShortName();
        } catch (ReflectionException $e) {
            Logger::getInstance()::exceptionHandler($e);
            $shortName = $calledClass;
        }
        return $shortName;
    }
}
