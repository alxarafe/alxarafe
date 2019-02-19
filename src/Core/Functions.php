<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../..');
}

if (!function_exists('basePath')) {
    /**
     * Returns the app base path.
     *
     * @param string $path
     *
     * @return string
     */
    function basePath(string $path = ''): string
    {
        return constant('BASE_PATH') . (empty($path) ? $path : DIRECTORY_SEPARATOR . $path);
    }
}

if (!function_exists('redirect')) {
    /**
     * Redirects to path.
     *
     * @param string $path
     */
    function redirect(string $path)
    {
        header('Location: ' . $path);
    }
}

if (!function_exists('baseUrl')) {
    /**
     * Returns the base url.
     *
     * @param string $url
     *
     * @return string
     */
    function baseUrl(string $url = ''): string
    {
        $baseUrl = sprintf(
            "%s://%s:%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME'],
            $_SERVER['SERVER_PORT']
        );

        if ($url) {
            return sprintf(
                '%s/%s',
                $baseUrl,
                $url
            );
        }

        return $baseUrl;
    }
}
