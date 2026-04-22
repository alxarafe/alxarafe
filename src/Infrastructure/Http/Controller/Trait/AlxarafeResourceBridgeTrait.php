<?php

namespace Alxarafe\Infrastructure\Http\Controller\Trait;

use Alxarafe\Infrastructure\Persistence\Frontend\TemplateGenerator;

trait AlxarafeResourceBridgeTrait
{
    /**
     * Overrides ViewController::afterAction to generate the view dynamically
     * using the TemplateGenerator before rendering.
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
            $action = $this->mode ?? 'edit';

            $basePath = defined('BASE_PATH') ? constant('BASE_PATH') : __DIR__ . '/../../../../..';
            $cacheDir = $basePath . '/../var/cache/resources/' . $module . '/' . $controller;
            $customDir = $basePath . '/../templates/custom/' . $module . '/' . $controller;

            $viewName = $action;
            $customFile = $customDir . '/' . $viewName . '.blade.php';

            if (file_exists($customFile)) {
                $this->addTemplatesPath($customDir);
                $this->setDefaultTemplate($viewName);
            } else {
                if (!is_dir($cacheDir)) {
                    mkdir($cacheDir, 0777, true);
                }

                $cacheFile = $cacheDir . '/' . $viewName . '.blade.php';

                if (!file_exists($cacheFile)) {
                    $generator = new TemplateGenerator();
                    $descriptor = $this->getViewDescriptor();
                    $descriptor['mode'] = $action;
                    $content = $generator->generate($descriptor);
                    file_put_contents($cacheFile, $content);
                    chmod($cacheFile, 0666);
                }

                if (file_exists($cacheFile)) {
                    $this->addTemplatesPath($cacheDir);
                    $this->setDefaultTemplate($viewName);
                }
            }
        }

        if (property_exists($this, 'structConfig')) {
            $this->addVariable('config', $this->structConfig);
        }
        $this->addVariable('viewDescriptor', $this->getViewDescriptor());
    }
}
