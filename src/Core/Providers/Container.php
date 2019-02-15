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
    /**
     * @var array
     */
    protected $container;

    /**
     * Container constructor.
     */
    public function __construct()
    {
        $this->container = [];
    }

    /**
     * @return array
     */
    public function getContainer(): array
    {
        return $this->container;
    }

    /**
     * Add new object to the container.
     *
     * @param string $key
     * @param mixed $object
     * @param bool $force
     *
     * @return bool
     */
    public function add(string $key, $object, bool $force = false)
    {
        $result = false;
        if (!isset($this->container[$key]) || $force) {
            $this->container[$key] = $object;
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
    public function get(string $key)
    {
        return $this->container[$key] ?? null;
    }
}
