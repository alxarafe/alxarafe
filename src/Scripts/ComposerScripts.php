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

namespace Rsanjoseo\Alxarafe\Scripts;

use Composer\Script\Event;

abstract class ComposerScripts
{
    public static function postUpdate(Event $event)
    {
        $composer = $event->getComposer();
        $io = $event->getIO();

        // Perform operations here
        $io->write("Running post-update script");

        static::copyAssets();
    }

    private static function copyAssets()
    {
        echo "Starting copyAssets...\n";

        if (getenv('SKIP_COPY_ASSETS')) {
            echo "Prevented copyAssets in scrutinizer environment.\n";
            return;
        }

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
        static::copyAssetsFolder($source, $target, 'css');
        static::copyAssetsFolder($source, $target, 'js');
        static::copyAssetsFolder($source, $target, 'img');
        echo "Assets copied successfully.\n";
    }

    private static function copyAssetsFolder($baseDir, $publicDir, $extension)
    {
        $dir = $baseDir . '/assets/' . $extension;
        if (!is_dir($dir)) {
            echo "Directory $dir does not exist.\n";
            return;
        }

        $targetDir = $publicDir . '/' . $extension;
        if (!is_dir($targetDir)) {
            if (!mkdir($targetDir, 0777, true) && !is_dir($targetDir)) {
                echo "Failed to create directory: $targetDir\n";
                return;
            }
        }

        foreach (glob($dir . '/*.' . $extension) as $file) {
            if (!copy($file, $publicDir . '/' . $extension . '/' . basename($file))) {
                echo "Failed to copy $file to $targetDir.\n";
                return;
            }
        }

        echo "Directory $dir copied successfully.\n";
    }
}