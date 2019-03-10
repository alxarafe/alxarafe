<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Helpers\Utils;

use Alxarafe\Core\Providers\ModuleManager;
use DirectoryIterator;
use SplFileInfo;

/**
 * Class FileSystemUtils
 *
 * @package Alxarafe\Core\Helpers
 */
class FileSystemUtils
{
    /**
     * Recursively removes a folder along with all its files and directories
     *
     * @param string $path
     *
     * @return bool
     */
    public static function rrmdir(string $path): bool
    {
        // Open the source directory to read in files
        if (!file_exists($path)) {
            return false;
        }
        $i = new DirectoryIterator($path);
        foreach ($i as $f) {
            if ($f->isFile()) {
                unlink($f->getRealPath());
            } elseif (!$f->isDot() && $f->isDir()) {
                self::rrmdir($f->getRealPath());
            }
        }
        return rmdir($path);
    }

    /**
     * Attempts to create the directory specified by pathname.
     *
     * @doc https://github.com/kalessil/phpinspectionsea/blob/master/docs/probable-bugs.md#mkdir-race-condition
     *
     * @param string $dir
     * @param int $mode
     * @param bool $recursive
     *
     * @return bool
     */
    public static function mkdir($dir, $mode = 0777, $recursive = false): bool
    {
        return !is_dir($dir) && !mkdir($dir, $mode, $recursive) && !is_dir($dir);
    }

    /**
     * List files and directories inside the specified path.
     *
     * @param string $path
     *
     * @return SplFileInfo[]
     */
    public static function scandir(string $path): array
    {
        $list = [];
        // Open the source directory to read in files
        $iterator = new DirectoryIterator($path);
        foreach ($iterator as $fileInfo) {
            if (!$fileInfo->isDot()) {
                $list[] = $fileInfo->getFileInfo();
            }
        }
        return $list;
    }

    /**
     * Locate a file in a subfolder, returning the FQCN or filepath.
     * The active modules of the last activated are traversed to the first, and finally the core.
     * The file is searched in the subfolder specified (for example Models).
     * If true (default), return the FQCN; if false, return the path to the file
     *
     * @param string $subfolder
     * @param string $file
     * @param bool $fqcn .
     * @return ?string
     */
    public static function locate(string $subfolder, string $file, bool $fqcn = true): ?string
    {
        $modules = [];
        foreach (ModuleManager::getEnabledModules() as $value) {
            $cad = $value['path'];
            $modules[] = substr($cad, strlen('src/'));    // Delete initial 'src\'
        }
        $modules[] = 'Alxarafe\Core';
        foreach ($modules as $module) {
            $filename = BASE_PATH . '/src/' . str_replace('\\', '/', $module) . '/' . $subfolder . '/' . $file . '.php';
            if (file_exists($filename)) {
                if ($fqcn) {
                    return '\\' . $module . '\\' . $subfolder . '\\' . $file;
                }
                return $filename;
            }
        }

        return null;
    }

}
