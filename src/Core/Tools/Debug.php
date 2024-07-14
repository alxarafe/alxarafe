<?php

/* Copyright (C) 2024      Rafael San José      <rsanjose@alxarafe.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace Alxarafe\Tools;

use Alxarafe\Tools\DebugBarCollector\PhpCollector;
use Alxarafe\Tools\DebugBarCollector\TranslatorCollector;
use DebugBar\DataCollector\DataCollectorInterface;
use DebugBar\DebugBar;
use DebugBar\DebugBarException;
use DebugBar\JavascriptRenderer;
use DebugBar\StandardDebugBar;

abstract class Debug
{
    /**
     * Private render instance
     *
     * @var JavascriptRenderer
     */
    private static JavascriptRenderer $render;

    /**
     * DebugBar instance
     *
     * @var StandardDebugBar
     */
    private static StandardDebugBar $debugBar;

    /**
     * Initializes the Debug
     *
     * @return bool
     * @throws DebugBarException
     */
    public static function initialize()
    {
        if (isset(self::$debugBar)) {
            return true;
        }

        return self::load();
    }

    /**
     * Gets the necessary calls to include the debug bar in the page header
     *
     * @return string
     * @throws DebugBarException
     */
    public static function getRenderHeader(): string
    {
        $result = "\n<!-- getRenderHeader -->\n";
        if (!isset(self::$render)) {
            return $result . '<!-- self::$render is not defined -->';
        }

        return $result . self::$render->renderHead();
    }

    /**
     * Load the debugbar and collectors.
     *
     * @return bool
     * @throws DebugBarException
     */
    private static function load(): bool
    {
        self::$debugBar = new StandardDebugBar();

        $shortName = 'Debug';
        self::startTimer($shortName, $shortName . ' DebugTool Constructor');

        self::addCollector(new PhpCollector());
        self::addCollector(new TranslatorCollector());

        $baseUrl = constant('BASE_URL') . '/alxarafe/assets/debugbar';
        $basePath = realpath(constant('BASE_PATH') . '/..') . '/';

        self::$render = self::getDebugBar()->getJavascriptRenderer($baseUrl, $basePath);

        self::stopTimer($shortName);

        return isset(self::$render);
    }

    /**
     * Initialize the timer
     *
     * @param string $name
     * @param string $message
     * @throws DebugBarException
     */
    public static function startTimer(string $name, string $message): void
    {
        if (!isset(self::$debugBar)) {
            return;
        }
        self::$debugBar['time']->startMeasure($name, $message);
    }

    /**
     * Add a new debugbar collector
     *
     * @param DataCollectorInterface $collector
     * @return DebugBar
     * @throws DebugBarException
     */
    public static function addCollector(DataCollectorInterface $collector): DebugBar
    {
        return self::$debugBar->addCollector($collector);
    }

    /**
     * Return the internal debug instance for get the html code.
     *
     * @return StandardDebugBar|null
     */
    public static function getDebugBar(): ?StandardDebugBar
    {
        if (!isset(self::$debugBar)) {
            return null;
        }
        return self::$debugBar;
    }

    /**
     * Stop the timer
     *
     * @param string $name
     * @throws DebugBarException
     */
    public static function stopTimer(string $name): void
    {
        if (!isset(self::$debugBar)) {
            return;
        }
        self::$debugBar['time']->stopMeasure($name);
    }

    /**
     * Gets the necessary calls to include the debug bar in the page footer
     *
     * @return string
     * @throws DebugBarException
     */
    public static function getRenderFooter(): string
    {
        $result = "\n<!-- getRenderFooter -->\n";
        if (!isset(self::$render)) {
            return $result . '<!-- self::$render is not defined -->';
        }

        return $result . self::$render->render();
    }

    /**
     * Add an exception to the exceptions tab of the debug bar.
     *
     * @param $exception
     * @throws DebugBarException
     */
    public static function addException($exception): void
    {
        if (!isset(self::$debugBar)) {
            return;
        }
        $caller = self::getCaller();
        self::$debugBar['exceptions']->addThrowable($caller['file'] . ' (' . $caller['line'] . '): ' . $exception);
    }

    /**
     * Locate last error
     *
     * @return array
     */
    private static function getCaller():array
    {
        $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[0];
        $caller['file'] = substr($caller['file'], strlen(constant('BASE_PATH')) - 7);
        return $caller;
    }

    public static function message(string $message): void
    {
        self::addMessage('messages', $message);
    }

    /**
     * Write a message in a channel (tab) of the debug bar.
     *
     * @param string $channel
     * @param string $message
     * @throws DebugBarException
     */
    private static function addMessage(string $channel, string $message): void
    {
        if (!isset(self::$debugBar)) {
            return;
        }

        if (!isset(self::$debugBar[$channel])) {
            self::$debugBar->addMessage('channel ' . $channel . ' does not exist. Message: ' . $message);
            return;
        }

        $caller = self::getCaller();
        self::$debugBar[$channel]->addMessage($caller['file'] . ' (' . $caller['line'] . '): ' . $message);
    }
}
