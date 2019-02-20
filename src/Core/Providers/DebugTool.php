<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Providers;

use Alxarafe\DebugBarCollectors\TranslatorCollector;
use DebugBar\Bridge\MonologCollector;
use DebugBar\DataCollector\MessagesCollector;
use DebugBar\DebugBarException;
use DebugBar\JavascriptRenderer;
use DebugBar\StandardDebugBar;
use Exception;

/**
 * Class DebugTool
 *
 * @package Alxarafe\Providers
 */
class DebugTool
{
    use Singleton {
        getInstance as getInstanceTrait;
    }

    /**
     * The debug bar.
     *
     * @var StandardDebugBar
     */
    private $debugTool;

    /**
     * The JS renderer.
     *
     * @var JavascriptRenderer
     */
    private $jsRender;

    /**
     * The logger.
     *
     * @var Logger
     */
    private $logger;

    /**
     * DebugTool constructor.
     */
    public function __construct()
    {
        if ($this->debugTool === null) {
            $this->initSingleton();
            if (!defined('DEBUG')) {
                define('DEBUG', false);
            }
            $this->debugTool = new StandardDebugBar();
            $this->logger = Logger::getInstance();
            try {
                $logger = Logger::getInstance();
                $this->debugTool->addCollector(new MonologCollector($logger->getLogger()));
                $this->debugTool->addCollector(new MessagesCollector('SQL'));
                //$this->debugTool->addCollector(new PhpCollector());
                $translator = Translator::getInstance();
                $this->debugTool->addCollector(new TranslatorCollector($translator));
            } catch (DebugBarException $e) {
                $this->logger::exceptionHandler($e);
            }
            $baseUrl = baseUrl('vendor/maximebf/debugbar/src/DebugBar/Resources');
            $this->jsRender = $this->debugTool->getJavascriptRenderer($baseUrl, constant('BASE_PATH'));
        }
    }

    /**
     * Add a new exception to the debug bar.
     *
     * @param Exception $exception
     */
    public function addException($e): void
    {
        $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[0];
        $caller['file'] = substr($caller['file'], strlen(constant('BASE_PATH')));
        $this->debugTool['exceptions']->addException($e);
        $this->logger::exceptionHandler($e);
    }

    /**
     * Return the internal debug instance for get the html code.
     *
     * TODO: Analizar qué funciones harían falta para el html y retornar el html.
     * Tal y como está ahora mismo sería dependiente de DebugBar. DebugBar debería de quedar TOTALMENTE encapsulado en
     * esta clase.
     *
     * @return StandardDebugBar
     */
    public function getDebugTool(): StandardDebugBar
    {
        return $this->debugTool;
    }

    /**
     * Return the render header needed when debug is enabled. Otherwise return an empty string.
     *
     * @return string
     */
    public function getRenderHeader(): string
    {
        if (constant('DEBUG')) {
            return $this->jsRender->renderHead();
        }
        return '';
    }

    /**
     * Return the render footer needed when debug is enabled. Otherwise return an empty string.
     *
     * @return string
     */
    public function getRenderFooter(): string
    {
        if (constant('DEBUG')) {
            return $this->jsRender->render();
        }
        return '';
    }

    /**
     * Start a timer by name and message
     *
     * @param string $name
     * @param string $message
     */
    public function startTimer(string $name, string $message = 'Timer started'): void
    {
        if (!$this->debugTool['time']->hasStartedMeasure($name)) {
            $this->debugTool['time']->startMeasure($name, $message);
        } else {
            $this->addMessage('messages', "Timer '" . $name . "' yet started and trying to start it again.");
        }
    }

    /**
     * Write a message in a channel (tab) of the debug bar.
     *
     * @param string $channel
     * @param string $message
     */
    public function addMessage(string $channel, string $message): void
    {
        $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[0];
        $caller['file'] = substr($caller['file'], strlen(constant('BASE_PATH')));
        $this->debugTool[$channel]->addMessage($caller['file'] . ' (' . $caller['line'] . '): ' . $message);
    }

    /**
     * Stop a timer by name.
     *
     * @param string $name
     */
    public function stopTimer(string $name): void
    {
        if ($this->debugTool['time']->hasStartedMeasure($name)) {
            $this->debugTool['time']->stopMeasure($name);
        } else {
            $this->addMessage('messages', "Timer '" . $name . "' not yet started and trying to stop it.");
        }
    }

    /**
     * Return this instance.
     *
     * @return DebugTool
     */
    public static function getInstance(): self
    {
        return self::getInstanceTrait();
    }
}
