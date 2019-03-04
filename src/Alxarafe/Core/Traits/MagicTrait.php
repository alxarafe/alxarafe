<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Traits;

use Exception;

/**
 * Trait MagicTrait. Contains magic methods: setter, getter, isset, call and has
 * To reduce code on pure PHP classes with good practices and recomendations.
 *
 * @package Alxarafe\Core\Traits
 */
trait MagicTrait
{
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
     * Intercepts calls to non-existent getters / setters
     * Looks at the beginning of $method to see if it's "get", "set", "has"
     * Uses preg_match() to extract the 2nd part of the match, which should produce the property name
     *
     * @param string $method
     * @param array  $params
     *
     * @return $this|bool|mixed|string|null
     * @throws Exception
     */
    public function __call(string $method, array $params)
    {
        preg_match('/^(get|set|has|is)(.*?)$/i', $method, $matches);
        $prefix = $matches[1] ?? '';
        $key = lcfirst($matches[2]) ?? '';
        switch ($prefix) {
            case 'get':
                return $this->{$key} ?? 'N/A';
            case 'set':
                $this->{$key} = $params[0];
                return $this;
            case 'has':
                return property_exists($this, $key);
            case 'is':
                return $this->{$key} == true;
            default:
                throw new Exception('Prefix ' . $prefix . ' not yet supported on ' . __CLASS__ . '.');
                break;
        }
    }
}
