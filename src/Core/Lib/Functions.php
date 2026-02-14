<?php

/* Copyright (C) 2024       Rafael San José         <rsanjose@alxarafe.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 * or see https://www.gnu.org/
 */

namespace Alxarafe\Lib;

abstract class Functions
{
    /**
     * Obtains the main url
     *
     * @return string
     */
    public static function getUrl()
    {
        $ssl = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on';
        $proto = strtolower($_SERVER['SERVER_PROTOCOL']);
        $proto = substr($proto, 0, strpos($proto, '/')) . ($ssl ? 's' : '');
        if (isset($_SERVER['HTTP_HOST'])) {
            $host = $_SERVER['HTTP_HOST'];
        } else {
            $port = $_SERVER['SERVER_PORT'];
            $port = ((!$ssl && $port == '80') || ($ssl && $port == '443')) ? '' : ':' . $port;
            $host = $_SERVER['SERVER_NAME'] . $port;
        }

        $script = $_SERVER['SCRIPT_NAME'];

        $script = substr($script, 0, strlen($script) - strlen('/index.php'));
        return $proto . '://' . $host . $script;
    }

    /**
     * This function is used to obtain the value of a POST variable, and if it does not exist
     * (for example, the first time the form is loaded), take a default value.
     *
     * @param $postVar
     * @param $defaultValue
     * @return mixed
     */
    public static function getIfIsset($postVar, $defaultValue)
    {
        $return = filter_input(INPUT_POST, $postVar);
        return ($return === null || $return === false) ? $defaultValue : $return;
    }

    /**
     * Defines the constant $name, if it is not already defined.
     *
     * @param string $name
     * @param        $value
     */
    public static function defineIfNotDefined(string $name, $value)
    {
        if (!defined($name)) {
            define($name, $value);
        }
    }

    /**
     * Convert an array of attributes to a string.
     *
     * @param array $attributes
     * @return string
     */
    public static function htmlAttributes(array $attributes): string
    {
        $_attributes = '';
        foreach ($attributes as $key => $value) {
            $_attributes .= $key . '="' . htmlspecialchars($value ?? '') . '" ';
        }
        return trim($_attributes);
    }

    public static function getThemes()
    {
        $routes = [
            '/templates/themes',
            '/src/templates/themes', // Fallback for vendor?
            '/vendor/alxarafe/alxarafe/templates/themes',
        ];

        $themes = ['default' => 'Default (System)'];

        foreach ($routes as $route) {
            $path = realpath(constant('ALX_PATH') . $route);
            if ($path && is_dir($path)) {
                $dirs = glob($path . '/*', GLOB_ONLYDIR) ?: [];
                foreach ($dirs as $dir) {
                    $name = basename($dir);
                    if ($name !== 'default') {
                        $themes[$name] = ucfirst($name);
                    }
                }
            }
        }

        return $themes;
    }

    /**
     * Gets the list of files that match a pattern, at the first path in the array
     * where the matching files exist.
     *
     * @param $pathArray
     * @param $pattern
     * @return string[]
     */
    public static function getFirstNonEmptyDirectory($pathArray, $pattern): array
    {
        foreach ($pathArray as $path) {
            $realPath = realpath(constant('BASE_PATH') . '/..' . $path);
            if ($realPath === false || !is_dir($realPath)) {
                continue;
            }
            $files = glob($realPath . '/*' . $pattern);
            if (!empty($files)) {
                $result = [];
                foreach ($files as $file) {
                    $result[$file] = basename($file, $pattern);
                }
                return $result;
            }
        }
        return [];
    }

    public static function httpRedirect(string $url)
    {
        if (defined('ALX_TESTING')) {
            throw new \Alxarafe\Base\Testing\HttpResponseException(['redirect' => $url], "Redirect to $url");
        }
        header('Location: ' . $url);
        die();
    }

    public static function exec(string $command): void
    {
        $output = [];
        $return_var = 0;
        exec($command, $output, $return_var);
        if ($return_var !== 0) {
            throw new \Exception("Command failed: $command. Output: " . implode("\n", $output));
        }
        \Alxarafe\Tools\Debug::message("Command executed: $command. Output: " . implode("\n", $output));
    }
}
