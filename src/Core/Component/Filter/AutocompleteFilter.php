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

namespace Alxarafe\Component\Filter;

use Alxarafe\Component\AbstractFilter;

class AutocompleteFilter extends AbstractFilter
{
    #[\Override]
    public function apply($query, $value): void
    {
        $query->where($this->field, '=', $value);
    }

    #[\Override]
    public function getType(): string
    {
        // Fallback to select for visibility if autocomplete type is not implemented in the view.
        return 'select';
    }
}
