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
use Modules\Agenda\Model\Address;
use Modules\Agenda\Model\Contact;
use Modules\Agenda\Model\ContactChannel;

/**
 * Seeds demo data for the Agenda module.
 * Creates contacts, shared addresses, and assigns communication channels.
 */
class AgendaSeeder extends Seeder
{
    #[\Override]
    protected function run(string $modelClass): void
    {
        // Ensure channel types exist (AgendaSeeder runs before ContactChannelSeeder alphabetically)
        new ContactChannelSeeder();

        // --- Addresses (shared) ---
        $officeAddress = Address::create([
            'address' => 'Calle Innovación, 42',
            'city' => 'Sevilla',
            'state' => 'Sevilla',
            'postal_code' => '41013',
            'country' => 'España',
            'additional_info' => 'Planta 3, Oficina B',
        ]);

        $homeAna = Address::create([
            'address' => 'Avenida de la Constitución, 15',
            'city' => 'Sevilla',
            'state' => 'Sevilla',
            'postal_code' => '41001',
            'country' => 'España',
        ]);

        $homeCarlos = Address::create([
            'address' => 'Rue de Rivoli, 88',
            'city' => 'Paris',
            'state' => 'Île-de-France',
            'postal_code' => '75004',
            'country' => 'France',
        ]);

        $homeLucia = Address::create([
            'address' => 'Friedrichstraße 123',
            'city' => 'Berlin',
            'state' => 'Berlin',
            'postal_code' => '10117',
            'country' => 'Deutschland',
        ]);

        $homeMartin = Address::create([
            'address' => 'Via Roma, 56',
            'city' => 'Roma',
            'state' => 'Lazio',
            'postal_code' => '00186',
            'country' => 'Italia',
        ]);

        // --- Contacts ---
        $ana = Contact::create([
            'first_name' => 'Ana',
            'last_name' => 'García López',
            'notes' => 'CEO of Alxarafe Technologies. Speaks Spanish and English.',
        ]);

        $carlos = Contact::create([
            'first_name' => 'Carlos',
            'last_name' => 'Martín Ruiz',
            'notes' => 'Lead developer. Based in Paris office.',
        ]);

        $lucia = Contact::create([
            'first_name' => 'Lucía',
            'last_name' => 'Fernández',
            'notes' => 'UX Designer. Works remotely from Berlin.',
        ]);

        $martin = Contact::create([
            'first_name' => 'Martín',
            'last_name' => 'Rossi',
            'notes' => 'Sales representative for Southern Europe.',
        ]);

        $elena = Contact::create([
            'first_name' => 'Elena',
            'last_name' => 'Santos',
            'notes' => 'Office manager at Sevilla HQ.',
        ]);

        // --- Address assignments (shared office address) ---
        $ana->addresses()->attach($officeAddress->id, ['label' => 'work']);
        $ana->addresses()->attach($homeAna->id, ['label' => 'home']);

        $carlos->addresses()->attach($officeAddress->id, ['label' => 'work']); // Same office!
        $carlos->addresses()->attach($homeCarlos->id, ['label' => 'home']);

        $lucia->addresses()->attach($homeLucia->id, ['label' => 'home']);

        $martin->addresses()->attach($homeMartin->id, ['label' => 'home']);
        $martin->addresses()->attach($officeAddress->id, ['label' => 'work']); // Same office!

        $elena->addresses()->attach($officeAddress->id, ['label' => 'work']); // Same office!

        // --- Channel assignments ---
        $phone = ContactChannel::where('name', 'Landline Phone')->first();
        $mobile = ContactChannel::where('name', 'Mobile Phone')->first();
        $email = ContactChannel::where('name', 'Email')->first();
        $linkedin = ContactChannel::where('name', 'LinkedIn')->first();
        $whatsapp = ContactChannel::where('name', 'WhatsApp')->first();

        if ($phone && $mobile && $email && $linkedin && $whatsapp) {
            // Ana
            $ana->channels()->attach($phone->id, ['value' => '+34 954 000 001']);
            $ana->channels()->attach($mobile->id, ['value' => '+34 600 111 222']);
            $ana->channels()->attach($email->id, ['value' => 'ana.garcia@alxarafe.com']);
            $ana->channels()->attach($linkedin->id, ['value' => 'https://linkedin.com/in/anagarcia']);

            // Carlos — shares office landline with Ana
            $carlos->channels()->attach($phone->id, ['value' => '+34 954 000 001']); // Same landline!
            $carlos->channels()->attach($mobile->id, ['value' => '+33 6 12 34 56 78']);
            $carlos->channels()->attach($email->id, ['value' => 'carlos.martin@alxarafe.com']);

            // Lucía
            $lucia->channels()->attach($mobile->id, ['value' => '+49 170 123 4567']);
            $lucia->channels()->attach($email->id, ['value' => 'lucia.fernandez@alxarafe.com']);
            $lucia->channels()->attach($whatsapp->id, ['value' => '+49 170 123 4567']);

            // Martín
            $martin->channels()->attach($mobile->id, ['value' => '+39 320 987 6543']);
            $martin->channels()->attach($email->id, ['value' => 'martin.rossi@alxarafe.com']);
            $martin->channels()->attach($linkedin->id, ['value' => 'https://linkedin.com/in/martinrossi']);

            // Elena — shares office landline
            $elena->channels()->attach($phone->id, ['value' => '+34 954 000 001']); // Same landline!
            $elena->channels()->attach($mobile->id, ['value' => '+34 600 333 444']);
            $elena->channels()->attach($email->id, ['value' => 'elena.santos@alxarafe.com']);
        }
    }

    #[\Override]
    protected static function model(): string
    {
        return Contact::class;
    }
}
