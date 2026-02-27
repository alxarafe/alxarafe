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
 * ContactChannel model representing a type of communication channel.
 * Master data table (e.g., phone, fax, mobile, email, social networks).
 *
 * @property int $id
 * @property string $name
 * @property string|null $icon
 */
class ContactChannel extends Model
{
    protected $table = 'contact_channels';

    protected $fillable = [
        'name',
        'icon',
    ];

    /**
     * Contacts using this channel type (many-to-many).
     */
    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'contact_contact_channel')
            ->withPivot('value')
            ->withTimestamps();
    }
}
