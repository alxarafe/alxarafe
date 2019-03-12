<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

if (!defined('BASE_PATH')) {
    /**
     * Base path for the app.
     */
    define('BASE_PATH', realpath(__DIR__ . constant('DIRECTORY_SEPARATOR') . '..' . constant('DIRECTORY_SEPARATOR') . '..' . constant('DIRECTORY_SEPARATOR') . '..'));
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
        return realpath(
            constant('BASE_PATH') .
            (empty($path) ? $path : constant('DIRECTORY_SEPARATOR') . trim($path, constant('DIRECTORY_SEPARATOR')))
        );
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
        $defaultPort = $_SERVER['SERVER_PORT'] ?? 80;
        $defaultHost = $_SERVER['SERVER_NAME'] ?? 'localhost';
        $folder = str_replace('/index.php', '', $_SERVER['PHP_SELF']);
        $port = '';
        if (!in_array($defaultPort, ['80', '443'], false)) {
            $port = ':' . $defaultPort;
        }
        $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http')
            . '://' . $defaultHost . $port . $folder;

        return empty($url) ? $baseUrl : $baseUrl . '/' . trim($url, '/');
    }
}
