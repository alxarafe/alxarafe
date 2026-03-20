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
 * Pivot model for the contact_contact_channel table.
 * Relates a Contact to a ContactChannel with a value (phone number, email, etc.).
 *
 * @property int $id
 * @property int $contact_id
 * @property int $contact_channel_id
 * @property string $value
 */
class ContactContactChannel extends Pivot
{
    protected $table = 'contact_contact_channel';

    public $incrementing = true;

    protected $fillable = [
        'contact_id',
        'contact_channel_id',
        'value',
    ];
}
