<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Helpers;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
use DebugBar\Bridge\Twig;
use DebugBar\DataCollector\MessagesCollector;
use DebugBar\DataCollector\PDO as PDODataCollector;
use DebugBar\StandardDebugBar;

/**
 * Class Debug
 *
 * @package Alxarafe\Helpers
 */
class Debug
{

    /**
     * @var StandardDebugBar
     */
    public static $debugBar;
    /**
     * @var \DebugBar\JavascriptRenderer
     */
    private static $render;
    /**
     * @var Logger
     */
    private static $logger;

    /**
     * Debug constructor.
     *
     * @throws \DebugBar\DebugBarException
     */
    public function __construct()
    {
        if (!defined('DEBUG')) {
            define('DEBUG', false);
        }

        self::$logger = new Logger('core_logger');
        self::$logger->pushHandler(new StreamHandler(BASE_PATH . 'core.log', Logger::DEBUG));
        self::$logger->pushHandler(new FirePHPHandler());

        self::$debugBar = new StandardDebugBar();
        self::$debugBar->addCollector(new MessagesCollector('SQL'));
        self::$debugBar->addCollector(new MessagesCollector('Deprecated'));
        $baseUrl = VENDOR_FOLDER . '/maximebf/debugbar/src/DebugBar/Resources';
        self::$render = Debug::getDebugBar()->getJavascriptRenderer($baseUrl, BASE_PATH);
    }

    /**
     * Check if the class is instanced, and instance it if not.
     * This method can be called, after use self::$debugBar in any method.
     *
     * @throws \DebugBar\DebugBarException
     */
    private static function checkInstance()
    {
        if (is_null(self::$debugBar)) {
            new self();
        }
    }

    /**
     * Return the internal debug instance for get the html code.
     *
     * TODO: Analizar qué funciones harían falta para el html y retornar el html.
     * Tal y como está ahora mismo sería dependiente de DebugBar. DebugBar debería
     * de quedar TOTALMENTE encapsulado en esta clase.
     *
     * @return StandardDebugBar
     * @throws \DebugBar\DebugBarException
     */
    public static function getDebugBar(): StandardDebugBar
    {
        self::checkInstance();
        return self::$debugBar;
    }

    /**
     * @return string
     * @throws \DebugBar\DebugBarException
     */
    public static function getRenderHeader(): string
    {
        if (DEBUG) {
            self::checkInstance();
            return self::$render->renderHead();
        }
        return '';
    }

    /**
     * @return string
     * @throws \DebugBar\DebugBarException
     */
    public static function getRenderFooter(): string
    {
        if (DEBUG) {
            self::checkInstance();
            return self::$render->render();
        }
        return '';
    }

    /**
     * Write a message in a channel (tab) of the debug bar.
     *
     * @param string $channel
     * @param string $message
     *
     * @throws \DebugBar\DebugBarException
     */
    public static function addMessage(string $channel, string $message): void
    {
        self::checkInstance();
        $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[0];
        $caller['file'] = substr($caller['file'], strlen(BASE_PATH));
        self::$debugBar[$channel]->addMessage($caller['file'] . ' (' . $caller['line'] . '): ' . $message);
    }

    /**
     * @param $exception
     *
     * @throws \DebugBar\DebugBarException
     */
    public static function addException($exception): void
    {
        self::checkInstance();
        $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[0];
        $caller['file'] = substr($caller['file'], strlen(BASE_PATH));
        self::$debugBar['exceptions']->addException($exception);
        self::$logger->info('Exception: ' . $exception->getMessage());
    }

    /**
     * @param string $name
     * @param string $message
     *
     * @throws \DebugBar\DebugBarException
     */
    public static function startTimer(string $name, string $message): void
    {
        self::checkInstance();
        self::$debugBar['time']->startMeasure($name, $message);
    }

    /**
     * @param string $name
     *
     * @throws \DebugBar\DebugBarException
     */
    public static function stopTimer(string $name): void
    {
        self::checkInstance();
        //self::$debugBar['time']->stopMeasure($name);
    }

    /**
     * @param      $text
     * @param      $array
     * @param bool $continue
     */
    public static function testArray($text, $array, $continue = false)
    {
        echo "<p><strong>$text</strong>:</p><pre>" . print_r((array) $array, true) . '</pre>';
        if (!$continue) {
            die('To avoid stopping the program, set a third parameter to Debug::testArray to true');
        }
    }
}
