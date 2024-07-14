<?php

/* Copyright (C) 2024       Rafael San José         <rsanjose@alxarafe.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace Rsanjoseo\Alxarafe;

use Composer\Installer\PackageEvent;
use Composer\Script\Event;

abstract class ComposerScripts
{
    public static function postUpdate(PackageEvent $event)
    {
        $io = $event->getIO();

        $io->write("*** Starting assets update process");

        if (getenv('SKIP_COPY_ASSETS')) {
            echo "Prevented copyAssets in scrutinizer environment.\n";
            return;
        }

        // Perform operations here
        $io->write("Running post-update script");

        static::copyAssets($io);
    }

    private static function makeDir($io, $path) {
        if ($path === false) {
            if (!mkdir($path, 0777, true) && !is_dir($path)) {
                $io->write("Failed to create target directory: $path");
                return false;
            }
        }
        return true;
    }

    private static function copyAssets($io)
    {
        $io->write("Starting copyAssets...");
        $io->write("Current directory: " . __DIR__);

        $source = realpath(__DIR__ . '/../../assets');
        if ($source === false) {
            $io->write("Source directory does not exist.");
            return;
        }

        $targetSource = __DIR__ . '/../../../../../public/alxarafe';
        $target = realpath($targetSource);
        if (!static::makeDir($io, $target)) {
            return;
        }

        $io->write("Copying assets from $source to $target...");
        if (!static::copyFolder($io, $source, $target)) {
            $io->write("An error has ocurred copying Assets.");
            return;
        }
        $io->write("Assets copied successfully.");
    }

    private static function copyFolder($io, string $source, string $target): bool
    {
        if (!static::makeDir($io, $target)) {
            return false;
        }

        $result = true;

        $dir = opendir($source);

        while (false !== ($file = readdir($dir))) {
            if (in_array($file, ['.', '..'])) {
                continue;
            }

            $sourcePath = $source . '/' . $file;
            $targetPath = $target . '/' . $file;

            if (is_dir($sourcePath)) {
                if (!static::copyFolder($io, $sourcePath, $targetPath)) {
                    $io->write("\nError copying $sourcePath folder to $targetPath");
                    $result = false;
                }
                continue;
            }

            if (!copy($sourcePath, $targetPath)) {
                $io->write("\nError copying $sourcePath to $targetPath");
                $result = false;
            }
        }

        closedir($dir);

        return $result;
    }
}