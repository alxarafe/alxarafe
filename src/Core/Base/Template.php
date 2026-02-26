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

namespace Alxarafe\Base;

use Alxarafe\Base\Config;
use Alxarafe\Lib\Functions;
use Jenssegers\Blade\Blade;

class Template
{
    protected ?string $templateName;
    protected array $paths = [];
    protected ?Blade $blade = null;

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
            if (class_exists(\CoreModules\Admin\Controller\ErrorController::class)) {
                $url = \CoreModules\Admin\Controller\ErrorController::url(true, false) . '&message=' . urlencode(\Alxarafe\Lib\Trans::_('template_no_view_specified'));
                \Alxarafe\Lib\Functions::httpRedirect($url);
            }
            return "No view specified.";
        }

        // Initialize Blade if paths are set
        if ($this->blade === null && !empty($this->paths)) {
            // Assuming cache path is writable and exists
            $cachePath = constant('BASE_PATH') . '/../var/cache/blade';
            if (!is_dir($cachePath)) {
                mkdir($cachePath, 0755, true);
            }

            // Fix: Use custom BladeContainer to support illuminate/view ^10
            $container = new \Alxarafe\Base\BladeContainer();
            \Illuminate\Container\Container::setInstance($container);

            $this->blade = new Blade($this->paths, $cachePath, $container);

            // Bind the View Factory contract to the 'view' service for component tag compilation
            $container->alias('view', \Illuminate\Contracts\View\Factory::class);

            // Bind a mock Application to satisfy Blade's ComponentTagCompiler (requires getNamespace())
            $container->singleton(\Illuminate\Contracts\Foundation\Application::class, function () {
                return new class {
                    public function getNamespace()
                    {
                        return 'Alxarafe\\';
                    }
                };
            });

            // Register all existing template paths as anonymous component paths
            foreach ($this->paths as $path) {
                $cleanPath = rtrim($path, '/');
                if (is_dir($cleanPath)) {
                    $this->blade->compiler()->anonymousComponentPath($cleanPath);
                }
            }

            // Template Tracer Hook
            if (class_exists(\Alxarafe\Tools\Debug::class)) {
                $this->blade->composer('*', function ($view) {
                    \Alxarafe\Tools\Debug::addTemplateTrace($view->getName(), $view->getPath());
                });
            }
        }

        $viewName = str_replace('/', '.', $view);

        if ($this->blade) {
            // Using Blade to render
            if ($this->blade->exists($viewName)) {
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
