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

namespace Modules\FrameworkTest\Model;

use Alxarafe\Base\Model\Model;

class TestModel extends Model
{
    protected $table = 'framework_test'; // Dummy

    protected $fillable = [
        'name',
        'description',
        'active',
        'type',
        'icon',
        'date',
        'datetime',
        'time',
        'integer',
        'decimal'
    ];

    public static function getFields(): array
    {
        return [
            'id' => ['field' => 'id', 'label' => 'ID', 'type' => 'integer', 'required' => true],
            'name' => ['field' => 'name', 'label' => 'Name', 'type' => 'text', 'required' => true, 'length' => 100],
            'description' => ['field' => 'description', 'label' => 'Description', 'type' => 'textarea'],
            'active' => ['field' => 'active', 'label' => 'Active', 'type' => 'boolean', 'default' => true],
            'type' => ['field' => 'type', 'label' => 'Type', 'type' => 'text'],
            'icon' => ['field' => 'icon', 'label' => 'Icon', 'type' => 'text'],
            'date' => ['field' => 'date', 'label' => 'Date', 'type' => 'date'],
            'datetime' => ['field' => 'datetime', 'label' => 'DateTime', 'type' => 'datetime'],
            'time' => ['field' => 'time', 'label' => 'Time', 'type' => 'time'],
            'integer' => ['field' => 'integer', 'label' => 'Integer', 'type' => 'integer'],
            'decimal' => ['field' => 'decimal', 'label' => 'Decimal', 'type' => 'decimal'],
        ];
    }
}
