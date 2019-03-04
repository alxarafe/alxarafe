<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

if (!defined('BASE_PATH')) {
    /**
     * Base path for the app.
     */
    define('BASE_PATH', __DIR__ . '/../../..');
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
        $folder = str_replace('/index.php', '', $_SERVER['PHP_SELF']);
        $port = '';
        if (!in_array($_SERVER['SERVER_PORT'], ['80', '443'])) {
            $port = ':' . $_SERVER['SERVER_PORT'];
        }
        $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http')
            . '://' . $_SERVER['SERVER_NAME'] . $port . $folder;

        return empty($url) ? $baseUrl : $baseUrl . '/' . $url;
    }
}
