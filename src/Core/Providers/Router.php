<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Providers;

/**
 * Class Routes
 * A route is a pair key => value, where key is the short name of the controller and the value the FQCN
 *
 * @package Alxarafe\Providers
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
            $this->separateConfigFile = true;
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
        if (isset($this->routes)) {
            return $this->routes;
        }

        return $this->loadRoutes();
    }

    /**
     * Set a new list of routes.
     *
     * @param array $routes
     */
    public function setRoutes(array $routes = [])
    {
        $this->routes = $routes;
    }

    /**
     * Load routes from configuration file.
     *
     * @return array
     */
    public function loadRoutes()
    {
        $this->routes = $this->getConfig();
        if (empty($this->routes)) {
            $this->routes = $this->getDefaultRoutes();
        }
        return $this->routes;
    }

    /**
     * Return a list of essential controllers.
     *
     * @return array
     */
    private function getDefaultRoutes()
    {
        return [
            'CreateConfig' => 'Alxarafe\\Controllers\\CreateConfig',
            'EditConfig' => 'Alxarafe\\Controllers\\EditConfig',
            'Login' => 'Alxarafe\\Controllers\\Login',
        ];
    }

    /**
     * Return this instance.
     *
     * @return Router
     */
    public static function getInstance(): self
    {
        return self::getInstanceTrait();
    }

    /**
     * Saves routes to configuration file.
     *
     * @return bool
     */
    public function saveRoutes()
    {
        return $this->setConfig($this->routes);
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
    public function addRoute(string $key, string $value, bool $force = false)
    {
        $return = false;
        if (!isset($this->routes[$key]) || $force) {
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
    public function hasRoute(string $key)
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
    public function getRoute(string $key)
    {
        return $this->routes[$key] ?? null;
    }
}
