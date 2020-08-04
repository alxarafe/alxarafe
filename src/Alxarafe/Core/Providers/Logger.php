<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Providers;

use DateTimeZone;
use Exception;
use Kint\Kint;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as MonologLogger;

/**
 * Class Logger
 *
 * @package Alxarafe\Core\Providers
 */
class Logger
{
    use Singleton {
        getInstance as getInstanceTrait;
    }

    /**
     * The logger.
     *
     * @var MonologLogger
     */
    private static $logger;

    /**
     * Logger constructor.
     */
    public function __construct()
    {
        if (!isset(self::$logger)) {
            $this->initSingleton();
            self::$logger = new MonologLogger('core_logger');
            set_exception_handler([$this, 'exceptionHandler']);
            try {
                // Maybe is needed a different timezone, at this moment sets the same.
                $timeZone = RegionalInfo::getInstance()->getConfig()['timezone'];
                self::$logger::setTimezone(new DateTimeZone($timeZone));
                self::$logger->pushHandler(new StreamHandler(basePath(DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'core.log'), MonologLogger::DEBUG));
            } catch (Exception $e) {
                Kint::dump($e);
            }
            self::$logger->pushHandler(new FirePHPHandler());
        }
    }

    /**
     * Catch the exception handler and adds to logger.
     *
     * @param Exception $e
     */
    public static function exceptionHandler($e): void
    {
        FlashMessages::getInstance()::setError($e->getMessage());
        Kint::dump($e);
        self::$logger->error(
            'Exception [' . $e->getCode() . ']: ' . $e->getMessage() . PHP_EOL
            . $e->getFile() . ':' . $e->getLine() . PHP_EOL
            . $e->getTraceAsString()
        );
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
        // TODO: Maybe is needed a different timezone than used on RegionalInfo, at this moment sets the same.
        return [];
    }

    /**
     * Returns the logger.
     *
     * @return MonologLogger
     */
    public function getLogger(): MonologLogger
    {
        return self::$logger;
    }
}
