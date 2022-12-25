<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Singletons;

/**
 * Class FlashMessages
 *
 * @package Alxarafe\Core\Providers
 */
class FlashMessages
{
    /**
     * Contains a message list for now.
     *
     * @var array
     */
    protected static array $messagesListNow;

    /**
     * Contains a message list for next.
     *
     * @var array
     */
    protected static array $messagesListNext;

    /**
     * Container constructor.
     */
    public function __construct(string $index = 'main')
    {
        self::$messagesListNow = [];
        self::$messagesListNext = [];
    }

    /**
     * Return the full container.
     *
     * @return array
     */
    public static function getContainer(): array
    {
        return Session::getFlash('messages') ?? [];
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
        // Logger::getInstance()->getLogger()->addError($msg);
        self::setFlash($when, $message);
    }

    /**
     * Set flash message.
     *
     * @param string $when
     * @param array  $message
     */
    private static function setFlash(string $when = 'now', array $message = []): void
    {
        switch ($when) {
            case 'now':
                self::$messagesListNow[] = $message;
                Session::setFlashNow('messages', self::$messagesListNow);
                break;
            case 'next':
            default:
                self::$messagesListNext[] = $message;
                Session::setFlashNext('messages', self::$messagesListNext);
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
        // Logger::getInstance()->getLogger()->addWarning($msg);
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
        // Logger::getInstance()->getLogger()->addInfo($msg);
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
        // Logger::getInstance()->getLogger()->addNotice($msg);
        self::setFlash($when, $message);
    }
}
