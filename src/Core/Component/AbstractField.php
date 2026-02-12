<?php

/* Copyright (C) 2026      Rafael San José      <rsanjose@alxarafe.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace Alxarafe\Component;

use Alxarafe\Component\Enum\ActionPosition;
use JsonSerializable;

abstract class AbstractField implements JsonSerializable
{
    protected string $component = 'text'; // Default blade component

    protected string $field;
    protected string $label;
    protected array $options = [];

    public function __construct(string $field, string $label, array $options = [])
    {
        $this->field = $field;
        $this->label = $label;

        // Auto-wrap options for frontend consistency (field.options.*),
        // unless already wrapped (by subclasses like Select that manually structure the payload)
        if (!empty($options) && !array_key_exists('options', $options)) {
            $this->options = ['options' => $options];
        } else {
            $this->options = $options;
        }
    }

    public function getColClass(): string
    {
        // Support direct option or nested option
        return $this->options['options']['col'] ?? $this->options['col'] ?? 'col-12';
    }

    abstract public function getType(): string;

    public function getField(): string
    {
        return $this->field;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getComponent(): string
    {
        return $this->component;
    }

    /**
     * @var array actions
     */
    protected array $actions = [];

    /**
     * Add an action button to the field.
     *
     * @param string $icon FontAwesome icon class (e.g. 'fas fa-globe')
     * @param string $onclick JavaScript code to execute on click
     * @param string $title Tooltip title
     * @param string $class Additional CSS classes for the button (default: btn-outline-secondary)
     * @param \Alxarafe\Component\Enum\ActionPosition $position 'left' or 'right' (default: ActionPosition::Left)
     * @return self
     */
    public function addAction(string $icon, string $onclick, string $title = '', string $class = 'btn-outline-secondary', \Alxarafe\Component\Enum\ActionPosition $position = \Alxarafe\Component\Enum\ActionPosition::Left): self
    {
        $this->actions[] = [
            'icon' => $icon,
            'onclick' => $onclick,
            'title' => $title,
            'class' => $class,
            'position' => $position->value
        ];
        return $this;
    }

    public function getActions(): array
    {
        return $this->actions;
    }

    public function clearActions(): self
    {
        $this->actions = [];
        return $this;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function mergeOptions(array $newOptions): void
    {
        // Recursively merge? Or shallow? Shallow merge on 'options' key if present, or root?
        // Our structure is $this->options['options'] holds the frontend payload.
        // If $newOptions are raw keys (e.g. ['maxlength' => 50]), we should put them into $this->options['options']

        if (isset($this->options['options'])) {
            $this->options['options'] = array_merge($this->options['options'], $newOptions);
        } else {
            // If strictly using wrapped mode, we create it.
            // If sticking to legacy root mode (unlikely now), we merge at root.
            // Given previous change, we largely enforce wrapping.
            $this->options['options'] = $newOptions;
        }
    }

    #[\ReturnTypeWillChange]
    #[\Override]
    public function jsonSerialize()
    {
        $data = array_merge([
            'field' => $this->field,
            'name' => $this->field, // Ensure 'name' is available for Blade templates
            'label' => $this->label,
            'component' => $this->component,
            'type' => $this->getType(),
            'actions' => $this->actions,
        ], $this->options);

        // Flatten 'options' if it exists, so keys like 'values' become top-level variables in Blade
        if (isset($data['options']) && is_array($data['options'])) {
            $data = array_merge($data, $data['options']);
        }

        return $data;
    }
}
