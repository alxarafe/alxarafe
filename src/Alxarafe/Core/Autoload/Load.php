<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Autoload;

use RuntimeException;
use function is_string;

/**
 * Class Load
 *
 * @package Alxarafe\Core\Autoload
 */
class Load
{
    /**
     * Message for throw exception.
     */
    public const UNABLE_TO_LOAD = 'Unable to load class';

    /**
     * Array of directories.
     *
     * @var array
     */
    protected static $dirs = [];

    /**
     * Total number of registered classes.
     *
     * @var int
     */
    protected static $registered = 0;

    /**
     * Hold the classes on instance.
     *
     * @var self
     */
    private static $instance;

    /**
     * Contains if loaded file exists.
     *
     * @param array $dirs
     */
    private static $fileExists;

    /**
     * @var array
     */
    private static $fileLoaded;

    /**
     * Load constructor.
     *
     * @param array|string $dirs
     */
    public function __construct($dirs = [])
    {
        if (!isset(self::$instance)) {
            self::$fileLoaded = [];
            self::$instance = $this;
            if (empty($dirs)) {
                $dirs = realpath(constant('BASE_PATH') . DIRECTORY_SEPARATOR . 'src');
            }
            self::init($dirs);
        }
    }

    /**
     * Adds a directory to the list of supported directories.
     * Also registers "autoload" as an autoloading method as a Standard PHP Library (SPL) autoloader.
     *
     * @param array|string $dirs
     */
    public static function init($dirs = []): void
    {
        // If composer autoload is available, try to load it.
        if (is_string($dirs)) {
            $autoload = dirname($dirs) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
            if (file_exists($autoload)) {
                require_once $autoload;
            }
        }

        if ($dirs) {
            self::addDirs($dirs);
        }
        if (self::$registered === 0) {
            spl_autoload_register(__CLASS__ . '::autoload');
            self::$registered++;
        }
    }

    /**
     * Add more directories to our list of directories to test.
     *
     * @param array|string $dirs
     */
    public static function addDirs($dirs): void
    {
        if (is_string($dirs)) {
            $dirs = [$dirs];
        }
        self::$dirs = array_merge(self::$dirs, $dirs);
    }

    /**
     * Return this instance.
     *
     * @return self
     */
    public static function getInstance(): self
    {
        return self::$instance;
    }

    /**
     * Performs the logic to locate the file based on the namespaced classname. This method derives a filename by
     * converting the PHP namespace separator \ into the directory separator appropriate for this server and appending
     * the extension .php.
     *
     * @param string $class
     *
     * @return bool
     * @throws RuntimeException
     */
    public static function autoLoad(string $class): bool
    {
        // Try to autoload by itself.
        $success = false;
        $fn = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
        foreach (self::$dirs as $start) {
            $file = $start . DIRECTORY_SEPARATOR . $fn;
            if (self::loadFile($file)) {
                $success = true;
                break;
            }
        }

        if (!$success && !self::loadFile(self::$dirs[0] . DIRECTORY_SEPARATOR . $fn)) {
            // Only throw the exception if missing class is from ower paths
            // NOTE: Can be '\Modules\Sample\Models\Country', 'Modules\Sample\Models\Country' or Country::class
            if (in_array(strpos($class, 'Alxarafe'), [0, 1], true) || in_array(strpos($class, 'Modules'), [0, 1], true)) {
                if (constant('DEBUG')) {
                    dump(debug_backtrace());
                }
                throw new RuntimeException(self::UNABLE_TO_LOAD . ' ' . $class);
            }
            $success = true;
        }
        return $success;
    }

    /**
     * Load a file if exists.
     * Returns true if file exists and is loaded, otherwise return false.
     *
     * The reason for this method is that if the file is not founded, we don't generate a fatal error when requiring it.
     *
     * @param string $file Path to the file or directory.
     *
     * @return bool
     */
    protected static function loadFile(string $file): bool
    {
        self::$fileExists = file_exists($file);
        if (in_array($file, self::$fileLoaded, true)) {
            return true;
        }
        if (self::$fileExists) {
            require_once $file;
            self::$fileLoaded[] = $file;
            return true;
        }
        return false;
    }
}
