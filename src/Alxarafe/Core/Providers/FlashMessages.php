<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Providers;

use Alxarafe\Core\Helpers\Session;

/**
 * Class FlashMessages
 *
 * @package Alxarafe\Core\Providers
 */
class FlashMessages
{
    use Singleton {
        getInstance as getInstanceTrait;
    }

    /**
     * Contains a message list for now.
     *
     * @var array
     */
    protected static $messagesListNow;

    /**
     * Contains a message list for next.
     *
     * @var array
     */
    protected static $messagesListNext;

    /**
     * Contains the session.
     *
     * @var Session
     */
    protected static $session;

    /**
     * Container constructor.
     */
    public function __construct()
    {
        if (!isset(self::$session)) {
            $this->separateConfigFile = true;
            self::$session = Session::getInstance();
            $this->initSingleton();
            self::$messagesListNow = [];
            self::$messagesListNext = [];
        }
    }

    /**
     * Return the full container.
     *
     * @return array
     */
    public static function getContainer(): array
    {
        return self::$messagesListNow;
    }

    /**
     * Register a new error message
     *
     * @param string $msg
     * @param string $when
     */
    public static function setError(string $msg, string $when = 'now'): void
    {
        $message = ['type' => 'danger', 'msg' => $msg];
        Logger::getInstance()->getLogger()->addError($msg);
        self::setFlash($when, $message);
    }

    /**
     * Set flash message.
     *
     * @param string $when
     * @param array  $message
     */
    private static function setFlash(string $when = 'now', array $message = [])
    {
        switch ($when) {
            case 'now':
                self::$messagesListNow[] = $message;
                self::$session->setFlashNow('messages', self::$messagesListNow);
                break;
            case 'next':
            default:
                self::$messagesListNext[] = $message;
                self::$session->setFlashNext('messages', self::$messagesListNext);
                break;
        }
    }

    /**
     * Register a new warning message
     *
     * @param string $msg
     * @param string $when
     */
    public static function setWarning(string $msg, string $when = 'now'): void
    {
        $message = ['type' => 'warning', 'msg' => $msg];
        Logger::getInstance()->getLogger()->addWarning($msg);
        self::setFlash($when, $message);
    }

    /**
     * Register a new info message
     *
     * @param string $msg
     * @param string $when
     */
    public static function setInfo(string $msg, string $when = 'now'): void
    {
        $message = ['type' => 'info', 'msg' => $msg];
        Logger::getInstance()->getLogger()->addInfo($msg);
        self::setFlash($when, $message);
    }

    /**
     * Register a new error message
     *
     * @param string $msg
     * @param string $when
     */
    public static function setSuccess(string $msg, string $when = 'now'): void
    {
        $message = ['type' => 'success', 'msg' => $msg];
        Logger::getInstance()->getLogger()->addNotice($msg);
        self::setFlash($when, $message);
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
}
