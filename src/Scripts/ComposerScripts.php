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

namespace Scripts;

use Composer\Installer\PackageEvent;

abstract class ComposerScripts
{
    public static function postUpdate(PackageEvent $event)
    {
        echo "\n*** Starting assets update process...\n\n";

        if (getenv('SKIP_COPY_ASSETS')) {
            echo "Prevented copyAssets in scrutinizer environment.\n";
            return;
        }

        $composer = $event->getComposer();
        $io = $event->getIO();

        // Perform operations here
        $io->write("Running post-update script");

        static::copyAssets();
    }

    private static function copyAssets()
    {
        echo "Starting copyAssets...\n";

        $source = realpath(__DIR__ . '/../assets');
        if ($source === false) {
            echo "Source directory does not exist.\n";
            return;
        }

        $target = realpath(__DIR__ . '/../../../../public/alxarafe');
        if ($target === false) {
            $target = __DIR__ . '/../../../../public/alxarafe';
            if (!mkdir($target, 0777, true) && !is_dir($target)) {
                echo "Failed to create target directory: $target\n";
                return;
            }
        }

        echo "Copying assets from $source to $target...\n";
        if (!static::copyFolder($source, $target)) {
            echo "An error has ocurred copying Assets.\n";
            return;
        }
        echo "Assets copied successfully.\n";
    }

    private static function copyFolder(string $source, string $target): bool
    {
        $result = true;

        $dir = opendir($source);

        while (false !== ($file = readdir($dir))) {
            if (in_array($file, ['.', '..'])) {
                continue;
            }

            $sourcePath = $source . '/' . $file;
            $targetPath = $target . '/' . $file;

            if (is_dir($sourcePath)) {
                if (!static::copyFolder($sourcePath, $targetPath)) {
                    echo "\nError copying $sourcePath folder to $targetPath\n";
                    $result = false;
                }
                continue;
            }

            if (!copy($sourcePath, $targetPath)) {
                echo "\nError copying $sourcePath to $targetPath\n";
                $result = false;
            }
        }

        closedir($dir);

        return $result;
    }
}