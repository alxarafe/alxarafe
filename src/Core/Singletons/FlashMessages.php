<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Singletons;

/**
 * Class FlashMessages
 *
 * Gestiona los mensajes de aviso y error de la aplicación.
 *
 * @author  Rafael San José Tovar <info@rsanjoseo.com>
 *
 * @package Alxarafe\Core\Singletons
 */
abstract class FlashMessages
{
    /**
     * Contiene la lista actual de mensajes
     *
     * @var array
     */
    private static array $messagesListNow;

    /**
     * Contiene la lista de mensajes para la próxima sesión
     *
     * @var array
     */
    private static array $messagesListNext;

    /**
     * Inicializa las variables
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @param string $index
     */
    public static function load(string $index = 'main')
    {
        Session::load($index);
        self::$messagesListNow = [];
        self::$messagesListNext = [];
    }

    /**
     * Retorna el contenido completo de los mensajes de sesión.
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @return array
     */
    public static function getContainer(): array
    {
        return Session::getFlash('messages') ?? [];
    }

    /**
     * Registra un nuevo mensaje de error
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
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
     * Registra un nuevo mensaje flash
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
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
     * Registra un nuevo mensaje de aviso
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
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
     * Registra un nuevo mensaje informativo
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
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
     * Registra un nuevo mensaje de error
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
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
