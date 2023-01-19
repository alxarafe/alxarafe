<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Singletons;

use Alxarafe\Core\Utils\ClassUtils;
use Aura\Session\Segment;
use Aura\Session\SessionFactory;

/**
 * Class Session.
 * Tools for managing sessions, including session segments and read-once messages
 *
 * @package Alxarafe\Core\Helpers
 */
class Session
{
    /**
     * Session info from cookie.
     *
     * @var \Aura\Session\Session
     */
    protected static \Aura\Session\Session $session;

    /**
     * Segment name.
     *
     * @var string
     */
    protected static string $segmentName = 'Alxarafe';

    /**
     * Session constructor.
     */
    public function __construct(string $index = 'main')
    {
        $shortName = ClassUtils::getShortName($this, static::class);
        Debug::startTimer($shortName, $shortName . ' Constructor');

        self::$session = (new SessionFactory())->newInstance($_COOKIE);
        if (session_status() === PHP_SESSION_NONE) {
            self::$session->start();
        }
        // https://github.com/auraphp/Aura.Session#cross-site-request-forgery

        Debug::stopTimer($shortName);
    }

    /**
     * Gets the value of the outgoing CSRF token.
     *
     * @return string
     */
    public static function getCsrfToken(): string
    {
        return self::$session->getCsrfToken()->getValue();
    }

    /**
     * Checks whether an incoming CSRF token value is valid.
     *
     * @param string $csrfToken
     *
     * @return bool
     */
    public static function isValid(string $csrfToken): bool
    {
        return self::$session->getCsrfToken()->isValid($csrfToken);
    }

    /**
     * Return this session.
     *
     * @return \Aura\Session\Session
     */
    public static function getSession(): \Aura\Session\Session
    {
        return self::$session;
    }

    /**
     * Sets segment name.
     *
     * @param string $segmentName
     *
     * @return Session
     */
    public static function setSegment(string $segmentName): self
    {
        self::$segmentName = $segmentName;
        return self();
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
        return self::getSegment()->get($key);
    }

    /**
     * Return segment session.
     *
     * @return Segment
     */
    public static function getSegment(): Segment
    {
        return self::$session->getSegment(self::$segmentName);
    }

    /**
     * Set data key.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function set(string $key, $value): self
    {
        self::getSegment()->set($key, $value);
        return $this;
    }

    /**
     * Sets flash next data by key.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function setFlash(string $key, $value): self
    {
        $this->setFlashNext($key, $value);
        return $this;
    }

    /**
     * Sets flash next data by key.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public static function setFlashNext(string $key, $value)
    {
        self::getSegment()->setFlash($key, $value);
    }

    /**
     * Get flash now data by key.
     *
     * @param string $key
     *
     * @return mixed
     */
    public static function getFlash(string $key)
    {
        return self::getFlashNow($key);
    }

    /**
     * Get flash now data by key.
     *
     * @param string $key
     *
     * @return mixed
     */
    public static function getFlashNow(string $key)
    {
        return self::getSegment()->getFlash($key);
    }

    /**
     * Sets flash now data by key.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return void
     */
    public static function setFlashNow(string $key, $value)
    {
        self::getSegment()->setFlashNow($key, $value);
    }

    /**
     * Get flash next data by key.
     *
     * @param string $key
     *
     * @return mixed
     */
    public static function getFlashNext(string $key)
    {
        return self::getSegment()->getFlashNext($key);
    }
}
