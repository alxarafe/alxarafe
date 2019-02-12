<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Helpers;

/**
 * Class TwigFunctions
 *
 * @package Alxarafe\Helpers
 */
class TwigFunctions
{
    /**
     * Session info from cookie.
     *
     * @var Session
     */
    protected $session;

    /**
     * TwigFunctions constructor.
     */
    public function __construct()
    {
        $this->session = Config::$session->getSingleton();
    }

    /**
     * Returns data messages from flash information.
     *
     * @param array  $params
     *
     * @return array|mixed
     */
    public function flash(array $params)
    {
        $return = [];
        $flashType = $params[0];
//        var_dump($flashType);
        $flash = $this->session->getFlash($flashType);
//        var_dump($flash);
        if ($flashType === 'post') {
            return  $flash;
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
    public function copyright()
    {
        return '<a target="_blank" href="https://alxarafe.es/">Alxarafe</a> 2018-' . date('Y') . ' &copy;';
    }

    /**
     * Unescape html entities.
     *
     * @param string $value
     *
     * @return string
     */
    public function unescape(string $value)
    {
        return html_entity_decode($value);
    }
}
