<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Traits;

/**
 * Trait MagicTrait. Contains magic methods: setter, getter, isset, call and has
 * To reduce code on pure PHP classes with good practices and recomendations.
 *
 * @package Alxarafe\Traits
 */
trait MagicTrait
{
    /**
     * Magic setter.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function __set(string $key, $value)
    {
        $method = 'set' . ucfirst($key);
        if (is_callable([$this, $method])) {
            $this->$method($value);
        } else {
            $this->{$key} = $value;
        }
    }

    /**
     * Magic isset.
     *
     * @param string $key
     *
     * @return bool
     */
    public function __isset(string $key)
    {
        return isset($this->{$key});
    }

    /**
     * Magic getter.
     *
     * @param string $key
     *
     * @return mixed|null
     */
    public function __get(string $key)
    {
        $method = 'get' . ucfirst($key);
        $value = (is_callable([$this, $method])) ? $this->$method() : $this->{$key};
        return $value ?? null;
    }

    /**
     * Intercepts calls to non-existent getters / setters
     * Looks at the beginning of $method to see if it's "get", "set", "has"
     * Uses preg_match() to extract the 2nd part of the match, which should produce the property name
     *
     * @param string $method
     * @param array  $params
     *
     * @return mixed
     */
    public function __call(string $method, array $params)
    {
        preg_match('/^(get|set)(.*?)$/i', $method, $matches);
        $prefix = $matches[1] ?? '';
        $key = lcfirst($matches[2]) ?? '';
        switch ($prefix) {
            case 'get':
                return $this->{$key} ?? 'N/A';
                break;
            case 'set':
                $this->{$key} = $params[0];
                break;
            case 'has':
                return property_exists($this, $key);
                break;
            default:
                throwException('Prefix ' . $prefix . ' not yet supported on ' . __CLASS__ . '.');
                break;
        }
    }
}