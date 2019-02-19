<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Providers;

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
    use Singleton;

    /**
     * The logger.
     *
     * @var Logger
     */
    private $logger;

    /**
     * Logger constructor.
     */
    public function __construct()
    {
        if ($this->logger === null) {
            $this->initSingleton();
            $this->logger = new MonologLogger('core_logger');
            set_exception_handler([$this, 'exceptionHandler']);
            try {
                $this->logger->pushHandler(new StreamHandler(basePath('/config/core.log'), MonologLogger::DEBUG));
            } catch (\Exception $e) {
                Kint::dump($e);
            }
            $this->logger->pushHandler(new FirePHPHandler());
        }
    }

    /**
     * Catch the exception handler and adds to logger.
     *
     * @param Exception $e
     */
    public function exceptionHandler($e)
    {
        Kint::dump($e);
        $this->logger->info(
            'Exception [' . $e->getCode() . ']: ' . $e->getMessage() . PHP_EOL
            . $e->getFile() . ':' . $e->getLine() . PHP_EOL
            . $e->getTraceAsString()
        );
    }
}
