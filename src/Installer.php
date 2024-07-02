<?php

namespace AlxRoot;

abstract class Installer
{
    public static function copyAssets()
    {
        if (getenv('SKIP_COPY_ASSETS')) {
            echo "Prevented copyAssets in scrutinizer environment.\n";
            return;
        }

        $source = realpath(__DIR__ . '/../assets');
        $target = realpath(__DIR__ . '/../../../../public/alxarafe');

        if (!file_exists($target)) {
            mkdir($target, 0777, true);
        }

        static::copyAssetsFolder($source, $target, 'css');
        static::copyAssetsFolder($source, $target, 'js');
        static::copyAssetsFolder($source, $target, 'img');
    }

    private static function copyAssetsFolder($baseDir, $publicDir, $extension)
    {
        $dir = $baseDir . '/assets/' . $extension;
        if (is_dir($dir)) {
            foreach (glob($dir . '/*.' . $extension) as $file) {
                copy($file, $publicDir . '/' . $extension . '/' . basename($file));
            }
        }
    }
}