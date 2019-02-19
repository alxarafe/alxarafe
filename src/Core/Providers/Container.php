<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Providers;

/**
 * Class Container
 *
 * @package Alxarafe\Providers
 */
class Container
{
    use Singleton;

    /**
     * @var array
     */
    protected static $container;

    /**
     * Container constructor.
     */
    public function __construct()
    {
        if (self::$container === null) {
            $this->separateConfigFile = true;
            $this->initSingleton();
            self::$container = [];
        }
    }

    /**
     * @return array
     */
    public static function getContainer(): array
    {
        return self::$container;
    }

    /**
     * Add new object to the container.
     *
     * @param string $key
     * @param mixed  $object
     * @param bool   $force
     *
     * @return bool
     */
    public static function add(string $key, $object, bool $force = false)
    {
        $result = false;
        if (!isset(self::$container[$key]) || $force) {
            self::$container[$key] = $object;
            $result = true;
        }
        return $result;
    }

    /**
     * Returns and object from the container if exists, or null.
     *
     * @param string $key
     *
     * @return mixed|null
     */
    public static function get(string $key)
    {
        return self::$container[$key] ?? null;
    }
}
