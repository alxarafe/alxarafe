<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Providers;

use Alxarafe\Core\DebugBarCollectors\PhpCollector;
use Alxarafe\Core\DebugBarCollectors\TranslatorCollector;
use Alxarafe\Core\Helpers\Utils\ClassUtils;
use DebugBar\Bridge\MonologCollector;
use DebugBar\DataCollector\MessagesCollector;
use DebugBar\DebugBarException;
use DebugBar\JavascriptRenderer;
use DebugBar\StandardDebugBar;
use Exception;

/**
 * Class DebugTool
 *
 * @package Alxarafe\Core\Providers
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
        if (!isset($this->debugTool)) {
            $shortName = ClassUtils::getShortName($this, static::class);
            $this->initSingleton();
            if (!defined('DEBUG')) {
                define('DEBUG', false);
            }
            $this->debugTool = new StandardDebugBar();
            $this->startTimer($shortName, $shortName . ' DebugTool Constructor');
            $this->logger = Logger::getInstance();
            try {
                $logger = Logger::getInstance();
                $this->debugTool->addCollector(new MonologCollector($logger->getLogger()));
                $this->debugTool->addCollector(new MessagesCollector('SQL'));
                $this->debugTool->addCollector(new PhpCollector());
                $translator = Translator::getInstance();
                $this->debugTool->addCollector(new TranslatorCollector($translator));
            } catch (DebugBarException $e) {
                $this->logger::exceptionHandler($e);
            }
            $baseUrl = baseUrl('vendor/maximebf/debugbar/src/DebugBar/Resources');
            $this->jsRender = $this->debugTool->getJavascriptRenderer($baseUrl, basePath());
            $this->stopTimer($shortName);
        }
    }

    /**
     * Start a timer by name and message
     *
     * @param string $name
     * @param string $message
     */
    public function startTimer(string $name, string $message = 'Timer started'): void
    {
        try {
            if (!$this->debugTool->getCollector('time')->/** @scrutinizer ignore-call */
            hasStartedMeasure($name)) {
                $this->debugTool->getCollector('time')->/** @scrutinizer ignore-call */
                startMeasure($name, $message);
            } else {
                $this->addMessage('messages', "Timer '" . $name . "' yet started and trying to start it again.");
            }
        } catch (DebugBarException $e) {
            Logger::getInstance()::exceptionHandler($e);
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
        $caller['file'] = substr($caller['file'], strlen(basePath()));
        try {
            $this->debugTool->getCollector($channel)->/** @scrutinizer ignore-call */
            addMessage($caller['file'] . ' (' . $caller['line'] . '): ' . $message);
        } catch (DebugBarException $e) {
            Logger::getInstance()::exceptionHandler($e);
        }
    }

    /**
     * Stop a timer by name.
     *
     * @param string $name
     */
    public function stopTimer(string $name): void
    {
        try {
            if ($this->debugTool->getCollector('time')->/** @scrutinizer ignore-call */
            hasStartedMeasure($name)) {
                $this->debugTool->getCollector('time')->/** @scrutinizer ignore-call */
                stopMeasure($name);
            } else {
                $this->addMessage('messages', "Timer '" . $name . "' not yet started and trying to stop it.");
            }
        } catch (DebugBarException $e) {
            Logger::getInstance()::exceptionHandler($e);
        }
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
     * Add a new exception to the debug bar.
     *
     * @param Exception $e
     */
    public function addException($e): void
    {
        $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[0];
        $caller['file'] = substr($caller['file'], strlen(basePath()));
        try {
            $this->debugTool->getCollector('exceptions')->/** @scrutinizer ignore-call */
            addException($e);
        } catch (DebugBarException $e) {
            Logger::getInstance()::exceptionHandler($e);
        }
        $this->logger::exceptionHandler($e);
    }

    /**
     * Return the internal debug instance.
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
}
