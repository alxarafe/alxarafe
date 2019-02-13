<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Helpers;

use Aura\Session\SessionFactory;

/**
 * Class Session.
 * Tools for managing sessions, including session segments and read-once messages
 *
 * @package Alxarafe\Helpers
 */
class Session
{
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
        // If is not yet started, started now
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->session = (new SessionFactory())->newInstance($_COOKIE);
    }

    /**
     * Return this instance.
     *
     * @return $this
     */
    public function getSingleton(): self
    {
        return $this;
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
     * Return segment session.
     *
     * @return \Aura\Session\Segment
     */
    public function getSegment()
    {
        return $this->session->getSegment($this->segmentName);
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
     * Get flash data by key.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function getFlash(string $key)
    {
        return $this->getSegment()->getFlashNext($key);
    }

    /**
     * Sets flash data by key.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function setFlash(string $key, $value)
    {
        $this->getSegment()->setFlash($key, $value);
    }
}
