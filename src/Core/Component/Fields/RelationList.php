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

namespace Alxarafe\Component\Fields;

use Alxarafe\Component\AbstractField;

class RelationList extends AbstractField
{
    protected string $component = 'relation_list';

    /**
     * @param string $relation Name of the relation method (e.g. 'addresses')
     * @param string $label Label for the list
     * @param array $columns List of columns to display: ['street', 'city'] or [['field'=>'street', 'label'=>'Calle']]
     * @param array $options Additional options
     */
    public function __construct(string $relation, string $label, array $columns = [], array $options = [])
    {
        // Wrap everything for the frontend
        $payload = array_merge($options, ['columns' => $columns]);
        parent::__construct($relation, $label, ['options' => $payload]);
    }

    #[\Override]
    public function getType(): string
    {
        return 'relation_list';
    }
}
