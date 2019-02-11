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
        $this->session = (new Session())->getSession();
    }

    /**
     * Returns data from flash information.
     *
     * @param array  $params
     *
     * @return mixed
     */
    public function flash(array $params)
    {
        $flash = $this->session->getSegment()->getFlash($params[0]);
        if ($flash) {
            if ($params[0] === 'post') {
                return $flash;
            }
            return sprintf(
                '<div style="width: %s" class="alert alert-%s">%s</div>',
                '100%',
                $params[1],
                $flash
            );
        }

        return null;
    }

    /**
     * @return string
     */
    public function copyright()
    {
        return '<a target="_blank" href="https://alxarafe.es/">Alxarafe</a> 2018-' . date('Y') . ' &copy;';
    }
}