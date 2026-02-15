<?php

namespace Alxarafe\Base\Frontend;

use Alxarafe\Base\Config;

class ThemeManager
{
    protected string $activeSkin = 'default';
    protected string $basePath;

    public function __construct()
    {
        $this->basePath = constant('ALX_PATH') . '/templates';
        if (defined('THEME_SKIN')) {
            $this->activeSkin = constant('THEME_SKIN');
        }
    }

    public function getActiveSkin(): string
    {
        if (class_exists(\Alxarafe\Lib\Auth::class) && \Alxarafe\Lib\Auth::isLogged() && !empty(\Alxarafe\Lib\Auth::$user->theme)) {
            return \Alxarafe\Lib\Auth::$user->theme;
        }
        return $this->activeSkin;
    }

    public function getLayoutTemplates(): array
    {
        // Old: components/layouts -> New: component/layouts DOES NOT EXIST
        // Wait, layouts are now in templates/layout/

        // Scan templates/layout
        $baseTemplates = $this->scanTemplates($this->basePath . '/layout', 'layout_');

        $skin = $this->getActiveSkin();
        $skinTemplates = [];
        if ($skin && $skin !== 'default') {
            $skinTemplates = $this->scanTemplates($this->basePath . "/themes/{$skin}/layout", 'layout_');
        }

        return array_merge($baseTemplates, $skinTemplates);
    }

    public function getFieldTemplates(): array
    {
        // Fields are likely under 'component/field' or similar?
        // Let's check where fields are.
        // User copied templates/common/component/* to templates/component/*
        // But previously fields were in 'components/fields'.
        // Let's check if 'templates/component' has subdirs.

        $baseTemplates = $this->scanFieldTemplatesRecursive($this->basePath . '/component/fields');

        $skin = $this->getActiveSkin();
        $skinTemplates = [];
        if ($skin && $skin !== 'default') {
            $skinTemplates = $this->scanFieldTemplatesRecursive($this->basePath . "/themes/{$skin}/component/fields");
        }

        return array_merge($baseTemplates, $skinTemplates);
    }

    private function scanFieldTemplatesRecursive(string $basePath): array
    {
        $templates = [];
        if (!is_dir($basePath)) return $templates;

        // Scan List Templates (templates/components/fields/list)
        $templates = array_merge($templates, $this->scanTemplates($basePath . '/list', '', '_list'));

        // Scan Edit Templates (templates/components/fields/edit)
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
            if ($file === '.' || $file === '..' || !str_ends_with($file, '.blade.php')) continue;

            $type = substr($file, 0, -10); // remove .blade.php
            $key = strtolower($prefix . $type . $suffix);
            $templates[$key] = file_get_contents($path . '/' . $file);
        }
        return $templates;
    }
}
