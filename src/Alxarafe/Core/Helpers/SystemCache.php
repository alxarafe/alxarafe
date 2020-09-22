<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Helpers;

use Alxarafe\Core\Base\CacheCore;
use Alxarafe\Core\Providers\FlashMessages;
use Alxarafe\Core\Providers\ModuleManager;
use Alxarafe\Core\Providers\Translator;

/**
 * Class SystemCache
 * @package Alxarafe\Core\Helpers
 */
class SystemCache
{
    /**
     * The translator manager.
     *
     * @var Translator
     */
    private static $translator;

    /**
     * Regenerate date used by pre-processes.
     */
    public static function regenerateData()
    {
        self::clearCache();
        ModuleManager::getInstance()::executePreprocesses();
    }

    /**
     * Clean the cache and yaml files that contain the summary of the table structure.
     *
     * @return bool
     */
    public static function clearCache()
    {
        self::setTranslator();

        CacheCore::getInstance()->getEngine()->clear();
        FlashMessages::getInstance()::setSuccess(self::$translator->trans('cache-cleared-successfully'));
        if (Schema::deleteSummaryFiles()) {
            FlashMessages::getInstance()::setSuccess(self::$translator->trans('summary-files-deleted-successfully'));
            return true;
        }
        FlashMessages::getInstance()::setError(self::$translator->trans('error-deleting-summary-files'));
        return false;
    }

    /**
     * Set translator if needed.
     */
    private static function setTranslator()
    {
        self::$translator = self::$translator === null ? Translator::getInstance() : self::$translator;
    }
}
