<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Helpers;

use DebugBar\DataCollector\MessagesCollector;
use DebugBar\DebugBarException;
use DebugBar\StandardDebugBar;
use Exception;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Class Debug
 *
 * @package Alxarafe\Helpers
 */
class Debug
{

    /**
     * TODO: Undocumented
     *
     * @var StandardDebugBar
     */
    public static $debugBar;
    /**
     * TODO: Undocumented
     *
     * @var \DebugBar\JavascriptRenderer
     */
    private static $render;
    /**
     * TODO: Undocumented
     *
     * @var Logger
     */
    private static $logger;

    /**
     * Debug constructor.
     */
    public function __construct()
    {
        if (!defined('DEBUG')) {
            define('DEBUG', false);
        }

        self::$logger = new Logger('core_logger');
        try {
            self::$logger->pushHandler(new StreamHandler(constant('BASE_PATH') . 'core.log', Logger::DEBUG));
        } catch (Exception $e) {
            Debug::addException($e);
        }
        self::$logger->pushHandler(new FirePHPHandler());

        self::$debugBar = new StandardDebugBar();
        try {
            self::$debugBar->addCollector(new MessagesCollector('SQL'));
            self::$debugBar->addCollector(new MessagesCollector('Deprecated'));
        } catch (DebugBarException $e) {
            Debug::addException($e);
        }
        $baseUrl = constant('VENDOR_URI') . '/maximebf/debugbar/src/DebugBar/Resources';
        self::$render = Debug::getDebugBar()->getJavascriptRenderer($baseUrl, constant('BASE_PATH'));
    }

    /**
     * TODO: Undocumented
     *
     * @param Exception $exception
     */
    public static function addException($exception): void
    {
        self::checkInstance();
        $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[0];
        $caller['file'] = substr($caller['file'], strlen(constant('BASE_PATH')));
        self::$debugBar['exceptions']->addException($exception);
        self::$logger->info('Exception: ' . $exception->getMessage());
    }

    /**
     * Check if the class is instanced, and instance it if not.
     * This method can be called, after use self::$debugBar in any method.
     */
    private static function checkInstance(): void
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
     */
    public static function getDebugBar(): StandardDebugBar
    {
        self::checkInstance();
        return self::$debugBar;
    }

    /**
     * TODO: Undocumented
     *
     * @return string
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
     * TODO: Undocumented
     *
     * @return string
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
     */
    public static function addMessage(string $channel, string $message): void
    {
        self::checkInstance();
        $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[0];
        $caller['file'] = substr($caller['file'], strlen(constant('BASE_PATH')));
        self::$debugBar[$channel]->addMessage($caller['file'] . ' (' . $caller['line'] . '): ' . $message);
    }

    /**
     * TODO: Undocumented
     *
     * @param string $name
     * @param string $message
     */
    public static function startTimer(string $name, string $message): void
    {
        self::checkInstance();
        if (!self::$debugBar['time']->hasStartedMeasure($name)) {
            self::$debugBar['time']->startMeasure($name, $message);
        } else {
            Debug::addMessage('messages', 'Timer ' . $name . ' yet started and trying to start it again.');
        }
    }

    /**
     * TODO: Undocumented
     *
     * @param string $name
     */
    public static function stopTimer(string $name): void
    {
        self::checkInstance();

        if (self::$debugBar['time']->hasStartedMeasure($name)) {
            self::$debugBar['time']->stopMeasure($name);
        } else {
            Debug::addMessage('messages', 'Timer ' . $name . ' not yet started and trying to stop it.');
        }
    }

    /**
     * TODO: Undocumented
     *
     * @param      $text
     * @param      $array
     * @param bool $continue
     */
    public static function testArray($text, $array, $continue = false): void
    {
        echo "<p><strong>$text</strong>:</p><pre>" . print_r((array) $array, true) . '</pre>';
        if (!$continue) {
            $msg = 'To avoid stopping the program, set a third parameter to Debug::testArray to true';
            $e = new Exception($msg);
            Debug::addException($e);
            die($msg);
        }
    }
}
