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

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Pivot model for the address_contact table.
 * Relates a Contact to an Address with an optional label.
 *
 * @property int $id
 * @property int $address_id
 * @property int $contact_id
 * @property string|null $label
 */
class AddressContact extends Pivot
{
    protected $table = 'address_contact';

    public $incrementing = true;

    protected $fillable = [
        'address_id',
        'contact_id',
        'label',
    ];
}
