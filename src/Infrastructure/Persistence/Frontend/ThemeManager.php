<?php

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace Alxarafe\Infrastructure\Persistence\Frontend;

use Alxarafe\Infrastructure\Persistence\Config;
use Alxarafe\Infrastructure\Auth\Auth;
use Alxarafe\Infrastructure\Lib\Trans;

/**
 * Class ThemeManager
 * Manages themes and template discovery for the Alxarafe framework.
 */
class ThemeManager
{
    protected string $activeSkin = 'default';
    protected string $basePath;

    public function __construct()
    {
        // In the new structure, ALX_PATH should point to the framework root
        $this->basePath = (defined('ALX_PATH') ? constant('ALX_PATH') : dirname(__DIR__, 4)) . '/templates';
        
        if (defined('THEME_SKIN')) {
            $this->activeSkin = constant('THEME_SKIN');
        }
    }

    public function getActiveSkin(): string
    {
        if (class_exists(Auth::class) && Auth::isLogged() && !empty(Auth::$user->theme)) {
            return Auth::$user->theme;
        }
        return $this->activeSkin;
    }

    /**
     * Returns the mapping of layout containers to their Blade templates.
     */
    public function getLayoutTemplates(): array
    {
        $baseTemplates = $this->scanTemplates($this->basePath . '/layout', 'layout_');

        $skin = $this->getActiveSkin();
        $skinTemplates = [];
        if ($skin && $skin !== 'default') {
            $skinTemplates = $this->scanTemplates($this->basePath . "/themes/{$skin}/layout", 'layout_');
        }

        return array_merge($baseTemplates, $skinTemplates);
    }

    /**
     * Returns the mapping of field components to their Blade templates.
     */
    public function getFieldTemplates(): array
    {
        $baseTemplates = $this->scanFieldTemplatesRecursive($this->basePath . '/form/fields');

        $skin = $this->getActiveSkin();
        $skinTemplates = [];
        if ($skin && $skin !== 'default') {
            $skinTemplates = $this->scanFieldTemplatesRecursive($this->basePath . "/themes/{$skin}/form/fields");
        }

        return array_merge($baseTemplates, $skinTemplates);
    }

    private function scanFieldTemplatesRecursive(string $basePath): array
    {
        $templates = [];
        if (!is_dir($basePath)) {
            return $templates;
        }

        // Scan List Templates (templates/component/form/fields/list)
        $templates = array_merge($templates, $this->scanTemplates($basePath . '/list', '', '_list'));

        // Scan Edit Templates (templates/component/form/fields/edit)
        $templates = array_merge($templates, $this->scanTemplates($basePath . '/edit', '', '_edit'));

        return $templates;
    }

    private function scanTemplates(string $path, string $prefix = '', string $suffix = ''): array
    {
        $templates = [];
        if (!is_dir($path)) {
            return $templates;
        }

        $files = scandir($path);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..' || !str_ends_with($file, '.blade.php')) {
                continue;
            }

            $type = substr($file, 0, -10); // remove .blade.php
            $key = strtolower($prefix . $type . $suffix);
            $filePath = $path . '/' . $file;
            
            if (is_file($filePath)) {
                $content = file_get_contents($filePath);

                // Translate markers like [trans:key]
                $content = preg_replace_callback('/\[trans:([^\]]+)\]/', function ($matches) {
                    return Trans::_($matches[1]);
                }, $content);

                $templates[$key] = $content;
            }
        }
        return $templates;
    }
}
