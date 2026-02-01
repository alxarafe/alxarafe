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

namespace Alxarafe\Base\Component\Filter;

use Alxarafe\Base\Component\AbstractFilter;

class TextFilter extends AbstractFilter
{
    public function apply(array &$whereParts, $value): void
    {
        if (class_exists('\Xnet\Core\DBSchema') && method_exists('\Xnet\Core\DBSchema', 'search_diacritic_insensitive')) {
            $whereParts[] = \Xnet\Core\DBSchema::search_diacritic_insensitive($this->field, $value);
        } else {
            $safeValue = addslashes($value);
            $whereParts[] = "LOWER({$this->field}) LIKE LOWER('%{$safeValue}%')";
        }
    }

    public function getType(): string
    {
        return 'text';
    }
}
