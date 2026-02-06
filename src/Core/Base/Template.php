<?php

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
    }

    public function setTemplateName(?string $name): void
    {
        $this->templateName = $name;
    }

    public function render(?string $view = null, array $data = []): string
    {
        $view = $view ?? $this->templateName;
        if (!$view) {
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
        }

        if ($this->blade) {
            // Using Blade to render
            // Note: Jenssegers/Blade expects dot notation for views usually, e.g. 'page.login'
            // But if $view is 'page/login', we might need to convert or ensure it works.
            // Blade typically supports / as separator too depending on version, but . is standard.
            $viewName = str_replace('/', '.', $view);

            if ($this->blade->exists($viewName)) {
                return $this->blade->make($viewName, $data)->render();
            }
        }

        // Fallback for simple view searching (or if Blade fails/not configured)
        extract($data);
        ob_start();

        $found = false;
        // Search in provided paths first
        foreach ($this->paths as $path) {
            // ... legacy include logic if needed, but Blade should handle it ...
        }

        // Simple fallback message if Blade fails
        if (!$found && (!$this->blade || !$this->blade->exists($viewName))) {
            return "View not found: $view. Searched in: " . implode(', ', $this->paths);
        }

        return ob_get_clean();
    }
}
