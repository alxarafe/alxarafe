<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Providers;

use Alxarafe\Core\Controllers\CreateConfig;
use Alxarafe\Core\Controllers\EditConfig;
use Alxarafe\Core\Controllers\Login;

/**
 * Class Routes
 * A route is a pair key => value, where key is the short name of the controller and the value the FQCN
 *
 * @package Alxarafe\Core\Providers
 */
class Router
{
    use Singleton {
        getInstance as getInstanceTrait;
    }

    /**
     * Contains all routes.
     *
     * @var array
     */
    private $routes;

    /**
     * Routes constructor.
     */
    protected function __construct()
    {
        if (!isset($this->routes)) {
            // The class uses its own configuration file
            $this->separateConfigFile = false;
            $this->initSingleton();
            $this->getRoutes();
        }
    }

    /**
     * Return a list of routes.
     *
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes ?? $this->loadRoutes();
    }

    /**
     * Set a new list of routes.
     *
     * @param array $routes
     */
    public function setRoutes(array $routes = []): void
    {
        $this->routes = $routes;
    }

    /**
     * Load routes from configuration file.
     *
     * @return array
     */
    public function loadRoutes(): array
    {
        $this->routes = $this->getConfig();
        if (empty($this->routes)) {
            $this->routes = self::getDefaultValues();
        }
        return $this->routes;
    }

    /**
     * Return default values
     *
     * @return array
     */
    public static function getDefaultValues(): array
    {
        return [
            'CreateConfig' => CreateConfig::class,
            'EditConfig' => EditConfig::class,
            'Login' => Login::class,
        ];
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
     * Saves routes to configuration file.
     *
     * @param bool $merge
     *
     * @return bool
     */
    public function saveRoutes(bool $merge = false): bool
    {
        return $this->setConfig($this->routes, $merge);
    }

    /**
     * Add a new route if is not yet added.
     * With forced can be added always.
     *
     * @param string $key
     * @param string $value
     * @param bool   $force
     *
     * @return bool
     */
    public function addRoute(string $key, string $value, bool $force = false): bool
    {
        $return = false;
        if ($force || !isset($this->routes[$key])) {
            $this->routes[$key] = $value;
            $return = true;
        }
        return $return;
    }

    /**
     * Returns if route is setted.
     *
     * @param string $key
     *
     * @return bool
     */
    public function hasRoute(string $key): bool
    {
        return isset($this->routes[$key]);
    }

    /**
     * Returns the FQCN if exists or null.
     *
     * @param string $key
     *
     * @return string|null
     */
    public function getRoute(string $key): ?string
    {
        return $this->routes[$key] ?? null;
    }
}
