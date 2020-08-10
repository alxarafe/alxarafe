<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
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
        return realpath(constant('BASE_PATH')) .
            (empty($path) ? $path : constant('DIRECTORY_SEPARATOR') . trim($path, constant('DIRECTORY_SEPARATOR')));
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
        $defaultPort = constant('SERVER_PORT') ?? 80;
        $defaultHost = constant('SERVER_NAME') ?? 'localhost';
        $path = $_SERVER['PHP_SELF'];
        // For PHPUnit tests, SERVER PHP_SELF contains 'vendor/bin/phpunit'
        if (isset($_SERVER['argv'][0]) && $_SERVER['PHP_SELF'] === $_SERVER['argv'][0]) {
            $path = '';
        }
        $folder = str_replace(['/index.php', constant('APP_URI')], '', $path);
        $port = '';
        if (!in_array($defaultPort, ['80', '443'], false)) {
            $port = ':' . $defaultPort;
        }
        $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http')
            . '://' . $defaultHost . $port . constant('APP_URI') . $folder;
        return empty($url) ? $baseUrl : $baseUrl . '/' . trim($url, '/');
    }
}

if (!function_exists('randomString')) {
    /**
     * Create a randomString
     *
     * @param int $length
     *
     * @return string
     */
    function randomString(int $length)
    {
        $random = '';
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        while (strlen($random) < $length) {
            try {
                $pos = random_int(0, strlen($characters) - 1);
            } catch (Exception $e) {
                $pos = mt_rand(0, strlen($characters) - 1);
            }
            $random .= $characters[$pos];
        }
        return str_shuffle($random);
    }
}

if (!function_exists('delTree')) {
    /**
     * Delete a directory with all its content
     *
     * @param $dir
     *
     * @return bool
     */
    function delTree($dir)
    {
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }
}
