<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Providers;

use Alxarafe\Helpers\Session;

/**
 * Class FlashMessages
 *
 * @package Alxarafe\Providers
 */
class FlashMessages
{
    use Singleton {
        getInstance as getInstanceTrait;
    }

    /**
     * Contains a message list.
     *
     * @var array
     */
    protected static $messagesList;

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
        if (!isset(self::$messagesList)) {
            $this->separateConfigFile = true;
            self::$session = Session::getInstance();
            $this->initSingleton();
            self::$messagesList = [];
        }
    }

    /**
     * Return the full container.
     *
     * @return array
     */
    public static function getContainer(): array
    {
        return self::$messagesList;
    }

    /**
     * Register a new error message
     *
     * @param string $msg
     */
    public static function setError(string $msg): void
    {
        self::$messagesList[] = [
            'type' => 'danger',
            'msg' => $msg,
        ];
        Logger::getInstance()->getLogger()->addError($msg);
        self::$session->setFlash('messages', self::$messagesList);
    }

    /**
     * Register a new warning message
     *
     * @param string $msg
     */
    public static function setWarning(string $msg): void
    {
        self::$messagesList[] = [
            'type' => 'warning',
            'msg' => $msg,
        ];
        Logger::getInstance()->getLogger()->addWarning($msg);
        self::$session->setFlash('messages', self::$messagesList);
    }

    /**
     * Register a new info message
     *
     * @param string $msg
     */
    public static function setInfo(string $msg): void
    {
        self::$messagesList[] = [
            'type' => 'info',
            'msg' => $msg,
        ];
        Logger::getInstance()->getLogger()->addInfo($msg);
        self::$session->setFlash('messages', self::$messagesList);
    }

    /**
     * Register a new error message
     *
     * @param string $msg
     */
    public static function setSuccess(string $msg): void
    {
        self::$messagesList[] = [
            'type' => 'success',
            'msg' => $msg,
        ];
        Logger::getInstance()->getLogger()->addNotice($msg);
        self::$session->setFlash('messages', self::$messagesList);
    }

    /**
     * Return this instance.
     *
     * @return Container
     */
    public static function getInstance(): self
    {
        return self::getInstanceTrait();
    }
}
