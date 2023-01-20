<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Singletons;

use DateTimeZone;
use Exception;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as MonologLogger;

/**
 * Class Logger
 *
 * @package Alxarafe\Core\Providers
 */
abstract class Logger
{
    /**
     * The logger.
     *
     * @var MonologLogger
     */
    private static MonologLogger $logger;

    /**
     * Logger constructor.
     */
    public static function load(string $index = 'main')
    {
        self::$logger = new MonologLogger('core_logger');
        set_exception_handler(['static', 'exceptionHandler']);
        try {
            $timeZone = RegionalInfo::$config['timezone'];
            self::$logger->setTimezone(
                new DateTimeZone($timeZone)
            );
            self::$logger->pushHandler(new StreamHandler(CONFIGURATION_DIR . '/core.log', MonologLogger::DEBUG));
        } catch (Exception $e) {
            dump($e);
        }
        self::$logger->pushHandler(new FirePHPHandler());
    }

    /**
     * Catch the exception handler and adds to logger.
     *
     * @param Exception $e
     */
    public static function exceptionHandler($e): void
    {
        FlashMessages::setError($e->getMessage());
        dump($e);
        self::$logger->error(
            'Exception [' . $e->getCode() . ']: ' . $e->getMessage() . PHP_EOL
            . $e->getFile() . ':' . $e->getLine() . PHP_EOL
            . $e->getTraceAsString()
        );
    }

    /**
     * Returns the logger.
     *
     * @return MonologLogger
     */
    public static function getLogger(): MonologLogger
    {
        return self::$logger;
    }
}
