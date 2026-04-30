<?php

namespace Alxarafe\Infrastructure\Http\Controller\Traits;

trait AlxarafeResourceBridgeTrait
{
    /**
     * Overrides ViewController::afterAction to generate the view dynamically
     * using the static templates before rendering.
     */
    public function afterAction(): bool
    {
        $this->renderView();
        return parent::afterAction();
    }

    protected function renderView(): void
    {
        if (!$this->getTemplateName()) {
            $module = static::getModuleName();
            $controller = static::getControllerName();
            $action = $this->mode;

            $basePath = defined('BASE_PATH') ? constant('BASE_PATH') : __DIR__ . '/../../../../..';
            $cacheDir = $basePath . '/../var/cache/resources/' . $module . '/' . $controller;
            $customDir = $basePath . '/../templates/custom/' . $module . '/' . $controller;

            $viewName = $action;
            $customFile = $customDir . '/' . $viewName . '.blade.php';

            if (file_exists($customFile)) {
                $this->addTemplatesPath($customDir);
                $this->setDefaultTemplate($viewName);
            } else {
                // Fallback to static generic templates
                $this->setDefaultTemplate('resource.' . $viewName);
            }
        }

        // Add config to view
        $this->addVariable('config', $this->structConfig);

        $jsConfig = [
            'mode' => $this->mode,
            'recordId' => $this->recordId ?? '',
            'config' => $this->structConfig,
            'templates' => $this->getJsTemplates()
        ];
        $this->addVariable('jsConfig', $jsConfig);
        $this->addVariable('viewDescriptor', $this->getViewDescriptor());
    }

    private function getJsTemplates(): array
    {
        $templates = [];
        
        // Define paths for templates from resource-controller
        $baseDir = '';
        if (defined('APP_PATH')) {
            $vendorPath = constant('APP_PATH') . '/../vendor/alxarafe/resource-controller/templates';
            $monoPath = constant('APP_PATH') . '/../../resource-controller/templates';
            
            if (is_dir($vendorPath)) {
                $baseDir = $vendorPath;
            } elseif (is_dir($monoPath)) {
                $baseDir = $monoPath;
            }
        }
        
        // Fallback using reflection
        if (!$baseDir && class_exists(\Alxarafe\ResourceController\AbstractResourceController::class)) {
            $reflector = new \ReflectionClass(\Alxarafe\ResourceController\AbstractResourceController::class);
            $baseDir = dirname($reflector->getFileName(), 3) . '/templates';
        }

        if (is_dir($baseDir)) {
            $ext = '.html';

            // 1. Layout Templates
            $layoutFiles = ['list', 'edit', 'pagination'];
            foreach ($layoutFiles as $fileBase) {
                $path = $baseDir . '/layout/' . $fileBase . $ext;
                if (file_exists($path)) {
                    $templates['layout_' . $fileBase] = file_get_contents($path);
                }
            }

            // 2. Form Field Templates
            $fieldsPath = $baseDir . '/component/form/fields';
            if (is_dir($fieldsPath)) {
                // List
                if (is_dir($fieldsPath . '/list')) {
                    foreach (scandir($fieldsPath . '/list') as $file) {
                        if (str_ends_with($file, $ext)) {
                            $type = substr($file, 0, -strlen($ext));
                            $templates[$type . '_list'] = file_get_contents($fieldsPath . '/list/' . $file);
                        }
                    }
                }
                // Edit
                if (is_dir($fieldsPath . '/edit')) {
                    foreach (scandir($fieldsPath . '/edit') as $file) {
                        if (str_ends_with($file, $ext)) {
                            $type = substr($file, 0, -strlen($ext));
                            $templates[$type . '_edit'] = file_get_contents($fieldsPath . '/edit/' . $file);
                        }
                    }
                }
            }
        }

        return $templates;
    }
}
