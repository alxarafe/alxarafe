<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Providers;

use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Routes
 * A route is a pair key => value, where key is the short name of the controller and the value the FQCN
 *
 * @package Alxarafe\Providers
 */
class Router extends Singleton
{
    /**
     * Contains all routes.
     *
     * @var array
     */
    private $routes;

    /**
     * Routes constructor.
     *
     * @param string $filePath
     */
    public function __construct()
    {
        parent::__construct();
        // The class uses its own configuration file
        self::$separateConfigFile = true;
        $this->routes = $this->getConfig();
        if (count($this->routes) == 0) {
            $this->routes = $this->getDefaultRoutes();
            $this->setConfig($this->routes);
        }
    }

    /**
     * Return a list of routes
     *
     * @return array
    public function getRoutes(): array
    {
        if (file_exists($this->filePath) && is_file($this->filePath)) {
            try {
                $fileContent = Yaml::parseFile($this->filePath);
            } catch (ParseException $e) {
                $fileContent = [];
            }

            return $fileContent;
        }

        return $this->getDefaultRoutes();
    }
     */
    /**
     * Set a new list of routes.
     *
     * @param array $routes
    public function setRoutes(array $routes = [])
    {
        $this->routes = $routes;
        $this->saveRoutes();
    }
     */

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
     * Persist routes to file.
    public function saveRoutes()
    {
        $yamlData = Yaml::dump($this->routes);
        return (bool) file_put_contents($this->filePath, $yamlData);
    }
     */

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
            $this->setConfig($this->routes);
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
