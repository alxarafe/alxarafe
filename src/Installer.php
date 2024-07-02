<?php

namespace AlxRoot;

abstract class Installer
{
    public static function copyAssets()
    {
        $baseDir = dirname(__DIR__);
        $publicDir = $baseDir . '/public/vendor/alxarafe';

        var_dump([$baseDir, $publicDir]);

        if (!file_exists($publicDir)) {
            mkdir($publicDir, 0777, true);
        }

        static::copyAssetsFolder($baseDir, $publicDir, 'css');
        static::copyAssetsFolder($baseDir, $publicDir, 'js');
        static::copyAssetsFolder($baseDir, $publicDir, 'img');
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