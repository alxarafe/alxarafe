<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core;

/**
 * Class InitializerAbstract
 *
 * @package Alxarafe\Core
 */
abstract class InitializerAbstract
{
    /**
     * Code to load on every exection.
     */
    abstract public static function init();

    /**
     * Code to load when module is installed.
     */
    abstract public static function install();

    /**
     * Code to load  when module is updated.
     */
    abstract public static function update();

    /**
     * Code to load  when module is enabled.
     */
    abstract public static function enabled();

    /**
     * Code to load  when module is disabled.
     */
    abstract public static function disabled();
}
