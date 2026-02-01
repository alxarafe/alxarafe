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

namespace Alxarafe\Base\Component;

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
        $this->options = $options;
    }

    abstract public function getType(): string;

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return array_merge([
            'field' => $this->field,
            'label' => $this->label,
            'component' => $this->component,
            'type' => $this->getType(),
        ], $this->options);
    }
}
