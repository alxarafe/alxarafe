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

namespace Modules\Agenda\Model;

use Alxarafe\Base\Model\Model;

/**
 * Address model representing a physical location.
 * Shared across contacts via many-to-many relationship.
 *
 * @property int $id
 * @property string $address
 * @property string|null $city
 * @property string|null $state
 * @property string|null $postal_code
 * @property string|null $country
 * @property string|null $additional_info
 */
class Address extends Model
{
    protected $table = 'addresses';

    protected $fillable = [
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'additional_info',
    ];

    /**
     * Contacts associated with this address (many-to-many).
     */
    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'address_contact')
            ->withPivot('label')
            ->withTimestamps();
    }
}
