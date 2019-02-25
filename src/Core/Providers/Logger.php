<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Providers;

use DateTimeZone;
use Exception;
use Kint\Kint;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as MonologLogger;

/**
 * Class Logger
 *
 * @package Alxarafe\Providers
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
                // TODO: At the moment, the time zone of the application is not selected anywhere.
                // Maybe with? date_default_timezone_set('Europe/Madrid');
                self::$logger->setTimezone(new DateTimeZone('Europe/Madrid'));
                self::$logger->pushHandler(new StreamHandler(basePath('/config/core.log'), MonologLogger::DEBUG));
            } catch (\Exception $e) {
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
    public static function exceptionHandler($e)
    {
        Kint::$enabled_mode = constant('DEBUG');
        Kint::dump($e);
        self::$logger->info(
            'Exception [' . $e->getCode() . ']: ' . $e->getMessage() . PHP_EOL
            . $e->getFile() . ':' . $e->getLine() . PHP_EOL
            . $e->getTraceAsString()
        );
    }

    /**
     * Return this instance.
     *
     * @return Logger
     */
    public static function getInstance(): self
    {
        return self::getInstanceTrait();
    }

    /**
     * Returns the logger.
     *
     * @return MonologLogger
     */
    public function getLogger()
    {
        return self::$logger;
    }
}
