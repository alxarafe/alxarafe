<?php
/**
 * Copyright (C) 2022-2023  Rafael San José Tovar   <info@rsanjoseo.com>
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
 */

namespace Alxarafe\Core\Singletons;

use Alxarafe\Core\Utils\Utils;

/**
 * Simple file cache
 */
abstract class PhpFileCache
{
    private static $config;

    /**
     * php_file_cache constructor.
     */
    public static function load()
    {
        self::$config = [
            'cache_path' => constant('TMP_DIR') . 'cache',
            'expires' => 60 * 24 * 365,
        ];
        Utils::createDir(self::$config['cache_path']);
    }

    /**
     * Get the data associated with a key
     *
     * @access public
     *
     * @param string $key
     *
     * @return mixed the content you put in, or null if expired or not found
     */
    public function get($key, $raw = false, $custom_time = null)
    {
        if (!$this->fileExpired($file = $this->getRoute($key), $custom_time)) {
            $content = file_get_contents($file);
            return $raw ? $content : unserialize($content);
        }

        return null;
    }

    /**
     * Check if a file has expired or not.
     *
     * @access public
     *
     * @param string $file the rout to the file
     * @param int    $time the number of minutes it was set to expire
     *
     * @return bool if the file has expired or not
     */
    public function fileExpired($file, $time = null)
    {
        if (file_exists($file)) {
            return (time() > (filemtime($file) + 60 * ($time ?? self::$config['expires'])));
        }

        return true;
    }

    /**
     * Get a route to the file associated to that key.
     *
     * @access public
     *
     * @param string $key
     *
     * @return string the filename of the php file
     */
    public function getRoute($key)
    {
        return self::$config['cache_path'] . '/' . md5($key) . '.php';
    }

    /**
     * Put content into the cache
     *
     * @access public
     *
     * @param string $key
     * @param mixed  $content the the content you want to store
     * @param bool   $raw     whether if you want to store raw data or not. If it is true, $content *must* be a string
     *
     * @return bool whether if the operation was successful or not
     */
    public function put($key, $content, $raw = false)
    {
        $dest_file_name = $this->getRoute($key);
        /** Use a unique temporary filename to make writes atomic with rewrite */
        $temp_file_name = str_replace(".php", uniqid("-", true) . ".php", $dest_file_name);
        $ret = @file_put_contents($temp_file_name, $raw ? $content : serialize($content));
        if ($ret !== false) {
            return @rename($temp_file_name, $dest_file_name);
        }
        @unlink($temp_file_name);
        return false;
    }

    /**
     * Delete data from cache
     *
     * @access public
     *
     * @param string $key
     *
     * @return bool true if the data was removed successfully
     */
    public function delete($key)
    {
        $done = true;
        $ruta = $this->getRoute($key);
        if (file_exists($ruta)) {
            $done = @unlink($ruta);
        }

        return $done;
    }

    /**
     * Flush all cache
     *
     * @access public
     * @return bool always true
     */
    public function flush()
    {
        foreach (scandir(getcwd() . '/' . self::$config['cache_path']) as $file_name) {
            if (file_exists(self::$config['cache_path'] . '/' . $file_name) && substr($file_name, -4) == '.php') {
                @unlink(self::$config['cache_path'] . '/' . $file_name);
            }
        }

        return true;
    }
}
