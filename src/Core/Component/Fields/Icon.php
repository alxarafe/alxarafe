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

namespace Alxarafe\Base\Component\Fields;

use Alxarafe\Base\Component\AbstractField;

class Icon extends AbstractField
{
    protected string $component = 'icon';
    protected array $map;

    /**
     * @param string $field
     * @param string $label
     * @param array $map Associative array mapping values to icon classes (e.g., ['1' => 'fas fa-check', '0' => 'fas fa-times'])
     * @param array $options
     */
    public function __construct(string $field, string $label, array $map = [], array $options = [])
    {
        parent::__construct($field, $label, $options);
        $this->map = $map;
    }

    public function getType(): string
    {
        return 'icon';
    }

    public function jsonSerialize()
    {
        $data = parent::jsonSerialize();
        $data['map'] = $this->map;
        return $data;
    }
}
