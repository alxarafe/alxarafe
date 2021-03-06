<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Providers;

/**
 * Class Container
 *
 * @package Alxarafe\Core\Providers
 */
class Container
{
    use Singleton {
        getInstance as getInstanceTrait;
    }

    /**
     * Contains all items added.
     *
     * @var array
     */
    protected static $container;

    /**
     * Container constructor.
     */
    public function __construct()
    {
        if (!isset(self::$container)) {
            $this->separateConfigFile = true;
            $this->initSingleton();
            self::$container = [];
        }
    }

    /**
     * Return the full container.
     *
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
    public static function add(string $key, $object, bool $force = false): bool
    {
        $result = false;
        if ($force || !isset(self::$container[$key])) {
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

    /**
     * Return this instance.
     *
     * @return self
     */
    public static function getInstance(): self
    {
        return self::getInstanceTrait();
    }

    /**
     * Return default values
     *
     * @return array
     */
    public static function getDefaultValues(): array
    {
        // Not really needed
        return [];
    }
}
