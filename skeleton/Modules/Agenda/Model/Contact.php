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
 * Contact model representing a person in the agenda.
 *
 * @property int $id
 * @property string $first_name
 * @property string|null $last_name
 * @property string|null $notes
 */
class Contact extends Model
{
    protected $table = 'contacts';

    protected $fillable = [
        'first_name',
        'last_name',
        'notes',
    ];

    /**
     * Addresses associated with this contact (many-to-many).
     */
    public function addresses()
    {
        return $this->belongsToMany(Address::class, 'address_contact')
            ->withPivot('label')
            ->withTimestamps();
    }

    /**
     * Communication channels associated with this contact (many-to-many).
     */
    public function channels()
    {
        return $this->belongsToMany(ContactChannel::class, 'contact_contact_channel')
            ->withPivot('value')
            ->withTimestamps();
    }
}
