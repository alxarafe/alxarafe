<?php
/**
 * Copyright (C) 2022-2023  Rafael San José Tovar   <info@rsanjoseo.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace Alxarafe\Core\Singletons;

use Alxarafe\Core\Singletons\DebugBarCollectors\PhpCollector;
use Alxarafe\Core\Singletons\DebugBarCollectors\MonologCollector;
use Alxarafe\Core\Singletons\DebugBarCollectors\TranslatorCollector;
use DebugBar\DataCollector\DataCollectorInterface;
use DebugBar\DataCollector\MessagesCollector;
use DebugBar\DebugBar;
use DebugBar\JavascriptRenderer;
use DebugBar\StandardDebugBar;

class Debug
{
    /**
     * Private logger instance
     *
     * @var Logger
     */
    //    public static Logger $logger;
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
     * DebugTool constructor.
     *
     * @throws DebugBarException
     */
    public function __construct()
    {
        //        self::$logger = Logger::getInstance();

        //        $shortName = ClassUtils::getShortName($this, $this);
        if (!defined('DEBUG')) {
            define('DEBUG', false);
        }
        $shortName = 'Debug';

        self::$debugBar = new StandardDebugBar();
        $this->startTimer($shortName, $shortName . ' DebugTool Constructor');

        self::addCollector(new MessagesCollector('SQL'));
        self::addCollector(new PhpCollector());
        self::addCollector(new MessagesCollector('Deprecated'));
        self::addCollector(new MonologCollector(Logger::getLogger()));
        self::addCollector(new TranslatorCollector());

        $baseUrl = VENDOR_URI . '/maximebf/debugbar/src/DebugBar/Resources';
        self::$render = self::getDebugBar()->getJavascriptRenderer($baseUrl, constant('BASE_DIR'));

        $this->stopTimer($shortName);
    }

    public static function addCollector(DataCollectorInterface $collector): DebugBar
    {
        return self::$debugBar->addCollector($collector);
    }

    /**
     * Initialize the timer
     *
     * @param string $name
     * @param string $message
     */
    public static function startTimer(string $name, string $message): void
    {
        if (!isset(self::$debugBar)) {
            self::$debugBar = new StandardDebugBar();
        }
        self::$debugBar['time']->startMeasure($name, $message);
    }

    /**
     * Return the internal debug instance for get the html code.
     *
     * TODO: Analizar qué funciones harían falta para el html y retornar el html.
     * Tal y como está ahora mismo sería dependiente de DebugBar. DebugBar debería
     * de quedar TOTALMENTE encapsulado en esta clase.
     *
     * @return StandardDebugBar
     * @throws DebugBarException
     */
    public static function getDebugBar(): StandardDebugBar
    {
        return self::$debugBar;
    }

    /**
     * Stop the timer
     *
     * @param string $name
     */
    public static function stopTimer(string $name): void
    {
        self::$debugBar['time']->stopMeasure($name);
    }

    /**
     * Gets the necessary calls to include the debug bar in the page header
     *
     * @return string
     */
    public static function getRenderHeader(): string
    {
        if (constant('DEBUG') !== true) {
            return '';
        }
        return self::$render->renderHead();
    }

    /**
     * Gets the necessary calls to include the debug bar in the page footer
     *
     * @return string
     */
    public static function getRenderFooter(): string
    {
        if (constant('DEBUG') !== true) {
            return '';
        }
        return self::$render->render();
    }

    /**
     * Add an exception to the exceptions tab of the debug bar.
     *
     * TODO: addException is deprecated!
     *
     * @param $exception
     */
    public static function addException($exception): void
    {
        if (constant('DEBUG') !== true) {
            return;
        }
        $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[0];
        $caller['file'] = substr($caller['file'], strlen(BASE_DIR));
        self::$debugBar['exceptions']->addException($exception); // Use addThrowable instead!
        Logger::info('Exception: ' . $exception->getMessage());
    }

    /**
     * Write a message in a channel (tab) of the debug bar.
     *
     * @param string $channel
     * @param string $message
     */
    public static function addMessage(string $channel, string $message): void
    {
        if (constant('DEBUG') !== true) {
            return;
        }
        $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[0];
        $caller['file'] = substr($caller['file'], strlen(BASE_DIR));
        self::$debugBar[$channel]->addMessage($caller['file'] . ' (' . $caller['line'] . '): ' . $message);
    }
}
