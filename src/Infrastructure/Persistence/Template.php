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

namespace Alxarafe\Infrastructure\Persistence;

use Alxarafe\Infrastructure\Persistence\Config;
use Alxarafe\Infrastructure\Lib\Functions;
use Jenssegers\Blade\Blade;

class Template
{
    protected ?string $templateName;
    protected array $paths = [];
    protected ?Blade $blade = null;
    protected static ?BladeContainer $globalContainer = null;

    public function __construct(?string $templateName = null)
    {
        $this->templateName = $templateName;
    }

    public function setPaths(array $paths): void
    {
        $this->paths = $paths;
        $this->blade = null;
    }

    public function addPath(string $path): void
    {
        if (!in_array($path, $this->paths)) {
            $this->paths[] = $path;
            $this->blade = null;
        }
    }

    public function setTemplateName(?string $name): void
    {
        $this->templateName = $name;
    }

    public function getTemplateName(): ?string
    {
        return $this->templateName;
    }

    public function render(?string $view = null, array $data = []): string|false
    {
        $view = $view ?? $this->templateName;
        if (!$view) {
            if (class_exists(\Modules\Admin\Controller\ErrorController::class)) {
                $url = \Modules\Admin\Controller\ErrorController::url() . '&message=' . urlencode(\Alxarafe\Infrastructure\Lib\Trans::_('template_no_view_specified'));
                \Alxarafe\Infrastructure\Lib\Functions::httpRedirect($url);
            }
            return "No view specified.";
        }

        // Initialize Blade if paths are set
        if ($this->blade === null && !empty($this->paths)) {
            // Theme-specific cache path to avoid cross-theme component spills
            $theme = \Alxarafe\Infrastructure\Persistence\Config::getConfig()?->main->theme ?? 'default';
            if (isset($_COOKIE['alx_theme'])) {
                $theme = $_COOKIE['alx_theme'];
            }
            
            $cachePath = constant('BASE_PATH') . '/../var/cache/blade/' . $theme;
            if (!is_dir($cachePath)) {
                mkdir($cachePath, 0755, true);
            }

            // Use a persistent container to avoid service loss between instances
            if (self::$globalContainer === null) {
                self::$globalContainer = new \Alxarafe\Infrastructure\Persistence\BladeContainer();
                \Illuminate\Container\Container::setInstance(self::$globalContainer);
            }
            $container = self::$globalContainer;

            $this->blade = new Blade($this->paths, $cachePath, $container);

            // Ensure the view service is correctly registered for component resolution
            $factory = $container->make('view');
            $container->instance(\Illuminate\Contracts\View\Factory::class, $factory);
            $container->alias('view', \Illuminate\Contracts\View\Factory::class);

            // Bind a mock Application to satisfy Blade's ComponentTagCompiler (requires getNamespace())
            if (!$container->bound(\Illuminate\Contracts\Foundation\Application::class)) {
                $container->singleton(\Illuminate\Contracts\Foundation\Application::class, function () {
                    return new class {
                        public function getNamespace()
                        {
                            return 'Alxarafe\\';
                        }
                    };
                });
            }

            // Register anonymous component paths
            foreach ($this->paths as $path) {
                $cleanPath = rtrim($path, '/');
                if (is_dir($cleanPath)) {
                    $this->blade->compiler()->anonymousComponentPath($cleanPath);
                    $this->blade->addNamespace(md5($cleanPath), $cleanPath);
                    // Explicitly add the __components namespace to the view factory to avoid 'No hint path' error
                    $this->blade->addNamespace('__components', $cleanPath);
                }
            }

            // Template Tracer Hook
            if (class_exists(\Alxarafe\Infrastructure\Tools\Debug::class)) {
                $this->blade->composer('*', function ($view) {
                    \Alxarafe\Infrastructure\Tools\Debug::addTemplateTrace($view->getName(), $view->getPath());
                });
            }
        }

        $viewName = str_replace('/', '.', $view);


        if ($this->blade) {
            $exists = $this->blade->exists($viewName);
            // Using Blade to render
            if ($exists) {
                return $this->blade->make($viewName, $data)->render();
            }
        }

        // Fallback for simple view searching (or if Blade fails/not configured)
        extract($data);
        ob_start();

        // Search in provided paths first
        foreach ($this->paths as $path) {
            $file = $path . '/' . $view . '.php';
            if (file_exists($file)) {
                include $file;
                return ob_get_clean();
            }
        }

        // Simple fallback message if Blade fails
        if ($this->blade && !$this->blade->exists($viewName)) {
            return "View not found: $view. Searched in: " . implode(', ', $this->paths);
        }

        return "View not found (Legacy): $view";
    }
}
