<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Helpers;

use Alxarafe\BootStrap;
use Alxarafe\Providers\DebugTool;
use Alxarafe\Providers\TemplateRender;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class TwigFunctions
 *
 * @package Alxarafe\Helpers
 */
class TwigFunctions extends AbstractExtension
{
    /**
     * To manage PHP Sessions.
     *
     * @var Session
     */
    private $session;

    /**
     * Manage the renderer.
     *
     * @var TemplateRender
     */
    private $renderer;

    /**
     * The debug tool used.
     *
     * @var DebugTool
     */
    private $debugTool;

    /**
     * TwigFunctions constructor.
     */
    public function __construct()
    {
        $shortName = Utils::getShortName($this, get_called_class());
        $this->debugTool = DebugTool::getInstance();
        $this->debugTool->startTimer($shortName, $shortName . ' TwigFunctions Constructor');

        $this->session = Session::getInstance();
        $this->renderer = TemplateRender::getInstance();

        $this->debugTool->stopTimer($shortName);
    }

    /**
     * Return a list of functions.
     *
     * @return TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('flash', [$this, 'flash']),
            new TwigFunction('copyright', [$this, 'copyright']),
            new TwigFunction('unescape', [$this, 'unescape']),
            new TwigFunction('snakeToCamel', [$this, 'snakeToCamel']),
            new TwigFunction('getResourceUri', [$this, 'getResourceUri']),
            new TwigFunction('getHeader', [$this, 'getHeader']),
            new TwigFunction('getFooter', [$this, 'getFooter']),
            new TwigFunction('getTotalTime', [$this, 'getTotalTime']),
        ];
    }

    /**
     * Returns data messages from flash information.
     *
     * @param array $params
     *
     * @return array|mixed
     */
    public function flash(array $params)
    {
        $return = [];
        $flashType = $params[0];
        $flash = $this->session->getFlash($flashType);
        if ($flashType === 'post') {
            return $flash;
        }
        if (!empty($flash)) {
            $return = $flash;
        }
        return $return;
    }

    /**
     * Returns the copyright content.
     *
     * @return string
     */
    public function copyright(): string
    {
        return '<a target="_blank" href="https://alxarafe.es/">Alxarafe</a> 2018-' . date('Y') . ' &copy;';
    }

    /**
     * Returns the total execution time.
     * NOTE: DebugBar needs around 2-10ms for itself (depends on data tabs on it).
     *
     * @param bool $inMilliseconds if true, return the time in ms, else in seconds
     *
     * @return string
     */
    public function getTotalTime($inMilliseconds = true)
    {
        $execTime = microtime(true) - BootStrap::getInstance()::getStartTime();
        return $inMilliseconds ? round($execTime * 1000, 3) . ' ms' : $execTime . ' s';
    }

    /**
     * Unescape html entities.
     *
     * @param string $value
     *
     * @return string
     */
    public function unescape(string $value): string
    {
        return html_entity_decode($value);
    }

    /**
     * Returns the string to camel case format.
     *
     * @param string $toCamel
     *
     * @return string
     */
    public function snakeToCamel(string $toCamel): string
    {
        return Utils::snakeToCamel($toCamel);
    }

    /**
     * Check different possible locations for the file and return the
     * corresponding URI, if it exists.
     *
     * @param string $path
     *
     * @return string
     */
    public function getResourceUri(string $path): string
    {
        return $this->renderer->getResourceUri($path);
    }

    /**
     * Returns the necessary html code in the header of the template, to display the debug bar.
     *
     * @return string
     */
    public function getHeader(): string
    {
        return $this->debugTool->getRenderHeader();
    }

    /**
     * Returns the necessary html code at the footer of the template, to display the debug bar.
     *
     * @return string
     */
    public function getFooter(): string
    {
        return $this->debugTool->getRenderFooter();
    }
}
