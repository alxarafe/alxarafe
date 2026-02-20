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

class Panel extends AbstractField
{
    protected string $component = 'panel';
    protected array $fields = [];

    public function __construct(string $title, array $fields = [], array $options = [])
    {
        // Use title slug as ID to allow merging of sections with same name (case-insensitive)
        $id = 'panel_' . strtolower(preg_replace('/[^a-zA-Z0-9]+/', '_', $title));
        parent::__construct($id, $title, $options);
        $this->fields = $fields;
    }

    #[\Override]
    public function getType(): string
    {
        return 'panel';
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    #[\ReturnTypeWillChange]
    #[\Override]
    public function jsonSerialize(): mixed
    {
        $data = parent::jsonSerialize();
        $fieldsData = [];
        foreach ($this->fields as $f) {
            if ($f instanceof AbstractField) {
                $fieldsData[] = $f->jsonSerialize();
            } else {
                $fieldsData[] = $f;
            }
        }
        $data['fields'] = $fieldsData;
        return $data;
    }
}
