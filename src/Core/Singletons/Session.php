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
abstract class Session
{
    /**
     * Información de sesión de la cookie.
     *
     * @var \Aura\Session\Session
     */
    protected static \Aura\Session\Session $session;

    /**
     * Nombre del segmento utilizado.
     *
     * @var string
     */
    protected static string $segmentName = 'Alxarafe';

    /**
     * Inicia la sesión.
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     * @source https://github.com/auraphp/Aura.Session#cross-site-request-forgery
     *
     * @param string $index
     */
    public static function load(string $index = 'main')
    {
        self::$session = (new SessionFactory())->newInstance($_COOKIE);
        if (session_status() === PHP_SESSION_NONE) {
            self::$session->start();
        }
    }

    /**
     * Obtiene un valor para el token CSRF.
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @return string
     */
    public static function getCsrfToken(): string
    {
        return self::$session->getCsrfToken()->getValue();
    }

    /**
     * Comprueba si el token es válido.
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
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
     * Retorna una instancia de la sesión.
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @return \Aura\Session\Session
     */
    public static function getSession(): \Aura\Session\Session
    {
        return self::$session;
    }

    /**
     * Establece un nombre de segmento
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @param string $segmentName
     *
     * @return static
     */
    public static function setSegment(string $segmentName): self
    {
        self::$segmentName = $segmentName;
        return self();
    }

    /**
     * Obtiene los datos del segmento
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
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
     * Obtiene el segmento de sesión
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @return Segment
     */
    public static function getSegment(): Segment
    {
        return self::$session->getSegment(self::$segmentName);
    }

    /**
     * Establece un valor a una clave.
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @param string $key
     * @param        $value
     *
     * @return $this
     */
    public function set(string $key, $value): self
    {
        self::getSegment()->set($key, $value);
        return $this;
    }

    /**
     * Establece un valor a una clave 'flash'
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @param string $key
     * @param        $value
     *
     * @return $this
     */
    public function setFlash(string $key, $value): self
    {
        $this->setFlashNext($key, $value);
        return $this;
    }

    /**
     * Establece un valor a una clave, para la próxima sesión
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @param string $key
     * @param        $value
     */
    public static function setFlashNext(string $key, $value)
    {
        self::getSegment()->setFlash($key, $value);
    }

    /**
     * Obtiene datos de una clave actual
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
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
     * Obtiene datos de una clave actual
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
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
     * Establece un valor a una clave 'Flash'
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @param string $key
     * @param        $value
     */
    public static function setFlashNow(string $key, $value)
    {
        self::getSegment()->setFlashNow($key, $value);
    }

    /**
     * Obtiene los datos de una clave 'flash' para la próxima sesión
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
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
