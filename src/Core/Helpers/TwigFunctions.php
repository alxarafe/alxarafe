<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Helpers;

use Alxarafe\Providers\Container;

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
    public function __construct(Container $container)
    {
        $this->session = $container->get('session')->getSingleton();
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
        $flash = $this->session->getFlash($flashType);
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

    /**
     * Returns the string to camel case format.
     *
     * @param string $toCamel
     *
     * @return string
     */
    public function snakeToCamel(string $toCamel)
    {
        return Utils::snakeToCamel($toCamel);
    }
}
