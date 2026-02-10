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

namespace Alxarafe\Scripts;

use Composer\Script\Event;

abstract class ComposerScripts
{
    /**
     * @param object $event Expected Composer\Script\Event but using object to avoid dependency requirement in this file
     */
    public static function postUpdate(object $event)
    {
        $io = $event->getIO();

        $io->write("*** Starting assets update process");

        // Perform operations here
        $io->write("Running post-update script");

        self::copyAssets($io);
    }

    private static function copyAssets($io)
    {
        $io->write("Starting copyAssets...");
        $io->write("Current directory: " . __DIR__);

        $source = realpath(__DIR__ . '/../../assets');
        $io->write("Assets directory: " . $source);
        if ($source === false) {
            $io->write("Source directory does not exist.");
            return;
        }

        $standardPublic = realpath(__DIR__ . '/../../../../../public');
        $devPublic = realpath(__DIR__ . '/../../skeleton/public');

        if ($standardPublic && is_dir($standardPublic)) {
            $public = $standardPublic;
        } elseif ($devPublic && is_dir($devPublic)) {
            $public = $devPublic;
        } else {
            // Fallback or create relative to root if neither exists?
            // Let's assume one must exist.
            $io->write("Initial Public directory search failed. Defaulting to standard path.");
            $public = $standardPublic ?: (__DIR__ . '/../../../../../public');
        }

        $io->write("Public directory: " . $public);

        $target = $public . '/alxarafe/assets';
        if (!self::makeDir($io, $target)) {
            return;
        }
        $io->write("Target directory: " . $target);

        $io->write("Copying assets from $source to $target...");
        if (!self::copyFolder($io, $source, $target)) {
            $io->write("An error has ocurred copying Assets.");
            return;
        }
        $io->write("Assets copied successfully.");

        self::publishThemes($io);
    }

    private static function publishThemes($io)
    {
        $io->write("Starting publishThemes...");

        // Source: templates/themes (relative to this script: ../../templates/themes)
        $source = realpath(__DIR__ . '/../../templates/themes');

        // Target: public folder (relative: ../../../../../public/themes)
        // Wait, standard structure is: vendor/package/src -> ../../../public ?
        // Using existing logic for $public path discovery
        $standardPublic = realpath(__DIR__ . '/../../../../../public');
        $devPublic = realpath(__DIR__ . '/../../skeleton/public');

        if ($standardPublic && is_dir($standardPublic)) {
            $public = $standardPublic;
        } elseif ($devPublic && is_dir($devPublic)) {
            $public = $devPublic;
        } else {
            $public = $standardPublic ?: (__DIR__ . '/../../../../../public');
        }
        $target = $public . '/themes';

        $io->write("Source themes: " . $source);
        $io->write("Target themes: " . $target);

        if ($source === false || !is_dir($source)) {
            $io->write("Source themes directory not found.");
            return;
        }

        if (!self::makeDir($io, $target)) {
            return;
        }

        // Copy each theme's CSS/JS assets
        // Structure: templates/themes/{theme}/{css|js|assets} -> public/themes/{theme}/{css|js|assets}
        // We do NOT want to copy .blade.php files to public.

        $themes = scandir($source);
        foreach ($themes as $theme) {
            if (in_array($theme, ['.', '..']) || !is_dir($source . '/' . $theme)) {
                continue;
            }

            $themeSource = $source . '/' . $theme;
            $themeTarget = $target . '/' . $theme;

            // Only care about 'css', 'js', 'assets', 'img' folders
            $assetFolders = ['css', 'js', 'assets', 'img', 'fonts'];

            foreach ($assetFolders as $folder) {
                $subSource = $themeSource . '/' . $folder;
                $subTarget = $themeTarget . '/' . $folder;

                if (is_dir($subSource)) {
                    $io->write("Publishing assets for theme '$theme' ($folder)...");
                    if (!self::makeDir($io, $themeTarget)) {
                        continue; // Skip if theme dir creation fails
                    }
                    // Copy the folder content
                    self::copyFolder($io, $subSource, $subTarget);
                }
            }
        }
        $io->write("Themes published successfully.");
    }

    private static function makeDir($io, $path)
    {
        if (is_dir($path)) {
            return true;
        }

        if (!mkdir($path, 0777, true) && !is_dir($path)) {
            $io->write("Failed to create target directory: $path");
            return false;
        }
        return true;
    }

    private static function copyFolder($io, string $source, string $target): bool
    {
        if (!self::makeDir($io, $target)) {
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
                if (!self::makeDir($io, $targetPath)) {
                    return false;
                }

                if (!self::copyFolder($io, $sourcePath, $targetPath)) {
                    $io->write("\nError copying $sourcePath folder to $targetPath");
                    $result = false;
                }
                continue;
            }

            $io->write("\nCopying $sourcePath to $targetPath");
            if (!copy($sourcePath, $targetPath)) {
                $io->write("\nError copying $sourcePath to $targetPath");
                $result = false;
            }
        }

        closedir($dir);

        return $result;
    }
}
