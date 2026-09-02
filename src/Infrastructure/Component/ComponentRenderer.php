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
            
            // Allow application to override templates
            if (defined('BASE_PATH')) {
                self::$renderer->addPath(constant('BASE_PATH') . '/templates');
            }
            
            // Core templates
            if (defined('ALX_PATH')) {
                self::$renderer->addPath(constant('ALX_PATH') . '/templates');
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
            $viewName = 'component/form/' . $componentName;
            $data = $component->jsonSerialize();
        } elseif ($component instanceof AbstractContainer) {
            $viewName = 'component/container/' . $component->getContainerType();
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

        if ($component instanceof AbstractField && isset($data['record'])) {
            if (($data['value'] ?? null) === null) {
                $data['value'] = self::extractValue((string)($data['field'] ?? ''), $data['record']);
            }
        }

        return (string) self::$renderer->render($viewName, $data);
    }

    private static function extractValue(string $field, mixed $record): mixed
    {
        $value = $record;
        foreach (explode('.', $field) as $key) {
            if (is_object($value) && isset($value->$key)) {
                $value = $value->$key;
            } elseif (is_array($value) && array_key_exists($key, $value)) {
                $value = $value[$key];
            } else {
                return null;
            }
        }
        return $value;
    }
}
