<?php

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);

namespace Alxarafe\Lib;

/**
 * Class Router
 * 
 * Manages URL routing and generation for friendly URLs.
 */
class Router
{
    private static array $routes = [];

    /**
     * Add a route to the system.
     * 
     * Example: Router::add('test-show', '/test/{id}', 'FrameworkTest.Test.show');
     * 
     * @param string $name Route identifier name
     * @param string $path URL path with placeholders like {slug}
     * @param string $target Target in format Module.Controller.Action
     * @param array $defaults Default values for placeholders
     */
    public static function add(string $name, string $path, string $target, array $defaults = []): void
    {
        self::$routes[$name] = [
            'path' => $path,
            'target' => $target,
            'defaults' => $defaults,
        ];
    }

    /**
     * Finds a route matching the current request path.
     * 
     * @param string $requestPath The path from REQUEST_URI
     * @return array|null The matched route data or null
     */
    public static function match(string $requestPath): ?array
    {
        $path = parse_url($requestPath, PHP_URL_PATH);
        if (strpos($path, '/index.php') === 0) {
            $path = substr($path, 10);
        }
        $requestPath = '/' . trim($path, '/');

        foreach (self::$routes as $name => $route) {
            $pattern = self::pathToRegex($route['path']);
            if (preg_match($pattern, $requestPath, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $parts = explode('.', $route['target']);

                return [
                    'name' => $name,
                    'module' => $parts[0],
                    'controller' => $parts[1] ?? '',
                    'action' => $parts[2] ?? 'index',
                    'params' => array_merge($route['defaults'], $params),
                ];
            }
        }

        return null;
    }

    /**
     * Generates a URL based on route name or module/controller/action.
     * 
     * @param string $module
     * @param string $controller
     * @param string $action
     * @param array $params
     * @return string|null
     */
    public static function generate(string $module, string $controller, string $action, array $params = []): ?string
    {
        $target = "{$module}.{$controller}.{$action}";

        foreach (self::$routes as $route) {
            if ($route['target'] === $target) {
                $url = $route['path'];
                foreach ($params as $key => $value) {
                    if (strpos($url, '{' . $key . '}') !== false) {
                        $url = str_replace('{' . $key . '}', (string)$value, $url);
                        unset($params[$key]);
                    }
                }

                // If all placeholders are replaced, we found our route
                if (strpos($url, '{') === false) {
                    if (!empty($params)) {
                        $url .= '?' . http_build_query($params);
                    }
                    return $url;
                }
            }
        }

        return null;
    }

    private static function pathToRegex(string $path): string
    {
        $regex = preg_quote($path, '/');
        $regex = preg_replace('/\\\{([a-zA-Z0-9_]+)\\\}/', '(?P<$1>[^/]+)', $regex);
        return '/^' . $regex . '$/';
    }

    public static function getRoutes(): array
    {
        return self::$routes;
    }
}
