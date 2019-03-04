<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Helpers;

use Alxarafe\Core\Providers\DebugTool;
use Alxarafe\Core\Providers\Singleton;
use Aura\Session\SessionFactory;

/**
 * Class Session.
 * Tools for managing sessions, including session segments and read-once messages
 *
 * @package Alxarafe\Core\Helpers
 */
class Session
{
    use Singleton {
        getInstance as getInstanceTrait;
    }

    /**
     * Session info from cookie.
     *
     * @var \Aura\Session\Session
     */
    protected $session;

    /**
     * Segment name.
     *
     * @var string
     */
    protected $segmentName = 'Alxarafe';

    /**
     * Session constructor.
     */
    public function __construct()
    {
        $shortName = Utils::getShortName($this, get_called_class());
        $debugTool = DebugTool::getInstance();
        $debugTool->startTimer($shortName, $shortName . ' Constructor');

        if ($this->session === null) {
            $this->session = (new SessionFactory())->newInstance($_COOKIE);
            if (session_status() == PHP_SESSION_NONE) {
                $this->session->start();
            }
            // https://github.com/auraphp/Aura.Session#cross-site-request-forgery
        }

        $debugTool->stopTimer($shortName);
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
     * Return this session.
     *
     * @return \Aura\Session\Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Sets segment name.
     *
     * @param string $segmentName
     */
    public function setSegment(string $segmentName)
    {
        $this->segmentName = $segmentName;
    }

    /**
     * Get data from segment.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get(string $key)
    {
        return $this->getSegment()->get($key);
    }

    /**
     * Return segment session.
     *
     * @return \Aura\Session\Segment
     */
    public function getSegment()
    {
        return $this->session->getSegment($this->segmentName);
    }

    /**
     * Set data key.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function set(string $key, $value)
    {
        $this->getSegment()->set($key, $value);
    }

    /**
     * Sets flash next data by key.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function setFlash(string $key, $value)
    {
        $this->setFlashNext($key, $value);
    }

    /**
     * Sets flash next data by key.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function setFlashNext(string $key, $value)
    {
        $this->getSegment()->setFlash($key, $value);
    }

    /**
     * Get flash now data by key.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function getFlash(string $key)
    {
        return $this->getFlashNow($key);
    }

    /**
     * Get flash now data by key.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function getFlashNow(string $key)
    {
        return $this->getSegment()->getFlash($key);
    }

    /**
     * Sets flash now data by key.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function setFlashNow(string $key, $value)
    {
        $this->getSegment()->setFlashNow($key, $value);
    }

    /**
     * Get flash next data by key.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function getFlashNext(string $key)
    {
        return $this->getSegment()->getFlashNext($key);
    }

    /**
     * Return default values
     *
     * @return array
     */
    protected function getDefaultValues(): array
    {
        // TODO: Implement getDefaultValues() method.
        return [];
    }
}