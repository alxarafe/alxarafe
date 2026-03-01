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

namespace Modules\Agenda\Seeders;

use Alxarafe\Base\Seeder;
use Modules\Agenda\Model\ContactChannel;

/**
 * Seeds the contact_channels master data table with standard communication types.
 */
class ContactChannelSeeder extends Seeder
{
    #[\Override]
    protected function run(string $modelClass): void
    {
        $channels = [
            ['name' => '#phone_landline', 'icon' => 'fas fa-phone'],
            ['name' => '#phone_mobile', 'icon' => 'fas fa-mobile-alt'],
            ['name' => '#fax', 'icon' => 'fas fa-fax'],
            ['name' => '#email', 'icon' => 'fas fa-envelope'],
            ['name' => '#website', 'icon' => 'fas fa-globe'],
            ['name' => '#linkedin', 'icon' => 'fab fa-linkedin'],
            ['name' => '#twitter', 'icon' => 'fab fa-x-twitter'],
            ['name' => '#instagram', 'icon' => 'fab fa-instagram'],
            ['name' => '#whatsapp', 'icon' => 'fab fa-whatsapp'],
            ['name' => '#telegram', 'icon' => 'fab fa-telegram'],
        ];

        foreach ($channels as $channel) {
            $modelClass::create($channel);
        }
    }

    #[\Override]
    protected static function model(): string
    {
        return ContactChannel::class;
    }
}
