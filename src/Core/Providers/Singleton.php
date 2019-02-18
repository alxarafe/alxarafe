<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Providers;

/**
 * Class Singleton
 *
 * @package Alxarafe\Providers
 */
abstract class Singleton
{
    // Hold the class instance.
    private static $instance = null;

    // The object is created from within the class itself
    // only if the class has no instance.
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    abstract static function getConfig();
}