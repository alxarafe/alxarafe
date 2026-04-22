<?php

namespace Alxarafe\Infrastructure\Component;

use Alxarafe\ResourceController\Component\AbstractField;
use Alxarafe\ResourceController\Component\Container\AbstractContainer;
use Alxarafe\Infrastructure\Persistence\Template;

class ComponentRenderer
{
    private static ?Template $renderer = null;

    public static function render(object $component, array $extraData = []): string
    {
        if (self::$renderer === null) {
            self::$renderer = new Template();
            if (defined('ALX_PATH')) {
                self::$renderer->addPath(constant('ALX_PATH') . '/templates');
            }
            if (defined('BASE_PATH')) {
                self::$renderer->addPath(constant('BASE_PATH') . '/templates');
            }
        }

        $viewName = '';
        $data = [];

        if ($component instanceof AbstractField) {
            $componentName = $component->getComponent();
            if ($componentName === 'text') {
                $componentName = 'input';
            } elseif ($componentName === 'select2') {
                $componentName = 'select';
            }
            $viewName = 'form/' . $componentName;
            $data = $component->jsonSerialize();
        } elseif ($component instanceof AbstractContainer) {
            $viewName = 'container/' . $component->getContainerType();
            $data = $component->jsonSerialize();
            // Container views often expect the object itself as $container
            $data['container'] = $component;
        }

        if (!$viewName) {
            return '';
        }

        $data = array_merge($data, $extraData);
        if (!isset($data['attributes']) && class_exists(\Illuminate\View\ComponentAttributeBag::class)) {
            $data['attributes'] = new \Illuminate\View\ComponentAttributeBag($data['options'] ?? []);
        }
        return (string) self::$renderer->render($viewName, $data);
    }
}
