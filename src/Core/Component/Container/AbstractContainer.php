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

namespace Alxarafe\Component\Container;

use Alxarafe\Component\AbstractField;

/**
 * Base class for all container components (Panel, TabGroup, Tab, HtmlContent).
 *
 * Containers hold children (AbstractField or AbstractContainer) and delegate
 * rendering to a Blade template in templates/container/{component}.blade.php.
 *
 * This follows the same render() pattern as AbstractField, which uses
 * templates/form/{component}.blade.php.
 */
abstract class AbstractContainer extends AbstractField
{
    /**
     * Blade template name inside templates/container/.
     */
    protected string $containerTemplate = 'panel';

    /**
     * @var array<AbstractField|AbstractContainer> Child components
     */
    protected array $children = [];

    public function __construct(string $field, string $label, array $children = [], array $options = [])
    {
        parent::__construct($field, $label, $options);
        $this->children = $children;
    }

    #[\Override]
    public function getType(): string
    {
        return 'container';
    }

    /**
     * @return array<AbstractField|AbstractContainer>
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * Render this container to HTML by delegating to its Blade template.
     *
     * Each container template receives:
     * - $container: the AbstractContainer instance itself
     * - $record: the current record data array
     * - All extra data passed to render()
     *
     * @param array $extraData Must include 'record' => array
     * @return string Rendered HTML
     */
    #[\Override]
    public function render(array $extraData = []): string
    {
        if (self::$renderer === null) {
            self::$renderer = new \Alxarafe\Base\Template();
            if (defined('ALX_PATH')) {
                self::$renderer->addPath(constant('ALX_PATH') . '/templates');
            }
            if (defined('BASE_PATH')) {
                self::$renderer->addPath(constant('BASE_PATH') . '/templates');
            }
        }

        $data = array_merge([
            'container' => $this,
            'children'  => $this->children,
            'label'     => $this->label,
            'field'     => $this->field,
            'col'       => $this->getColClass(),
            'class'     => $this->options['options']['class'] ?? $this->options['class'] ?? '',
        ], $extraData);

        return (string) self::$renderer->render('container/' . $this->containerTemplate, $data);
    }

    /**
     * Render a single child component.
     * Called from within container Blade templates.
     *
     * If the child is a container, calls render() recursively.
     * If the child is a leaf field, resolves value from $record and renders.
     */
    public static function renderChild(AbstractField $child, array $record): string
    {
        if ($child instanceof AbstractContainer) {
            return $child->render(['record' => $record]);
        }

        // Leaf field — resolve value from record
        $fieldName = $child->getField();
        $value = $record[$fieldName] ?? null;

        // Dot-notation resolution (e.g. 'main.theme' → $record['main']['theme'])
        if ($value === null && str_contains($fieldName, '.')) {
            $keys = explode('.', $fieldName);
            $val = $record;
            foreach ($keys as $k) {
                $val = is_object($val) ? ($val->$k ?? null) : ($val[$k] ?? null);
            }
            $value = $val;
        }

        return '<div class="' . $child->getColClass() . '">'
            . $child->render(['value' => $value, 'name' => 'data[' . $fieldName . ']'])
            . '</div>';
    }
}
