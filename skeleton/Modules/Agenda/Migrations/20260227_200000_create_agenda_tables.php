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

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Capsule::schema()->hasTable('contacts')) {
            Capsule::schema()->create('contacts', function (Blueprint $table) {
                $table->id();
                $table->string('first_name', 100);
                $table->string('last_name', 100)->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        if (!Capsule::schema()->hasTable('addresses')) {
            Capsule::schema()->create('addresses', function (Blueprint $table) {
                $table->id();
                $table->string('address', 255);
                $table->string('city', 100)->nullable();
                $table->string('state', 100)->nullable();
                $table->string('postal_code', 20)->nullable();
                $table->string('country', 100)->nullable();
                $table->text('additional_info')->nullable();
                $table->timestamps();
            });
        }

        if (!Capsule::schema()->hasTable('address_contact')) {
            Capsule::schema()->create('address_contact', function (Blueprint $table) {
                $table->id();
                $table->foreignId('address_id')->constrained('addresses')->onDelete('cascade');
                $table->foreignId('contact_id')->constrained('contacts')->onDelete('cascade');
                $table->string('label', 50)->nullable()->comment('e.g. home, work, partner');
                $table->timestamps();

                $table->unique(['address_id', 'contact_id', 'label']);
            });
        }

        if (!Capsule::schema()->hasTable('contact_channels')) {
            Capsule::schema()->create('contact_channels', function (Blueprint $table) {
                $table->id();
                $table->string('name', 100);
                $table->string('icon', 100)->nullable();
                $table->timestamps();
            });
        }

        if (!Capsule::schema()->hasTable('contact_contact_channel')) {
            Capsule::schema()->create('contact_contact_channel', function (Blueprint $table) {
                $table->id();
                $table->foreignId('contact_id')->constrained('contacts')->onDelete('cascade');
                $table->foreignId('contact_channel_id')->constrained('contact_channels')->onDelete('cascade');
                $table->string('value', 255)->comment('The actual phone number, email, URL, etc.');
                $table->timestamps();

                $table->index(['contact_id', 'contact_channel_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Capsule::schema()->dropIfExists('contact_contact_channel');
        Capsule::schema()->dropIfExists('address_contact');
        Capsule::schema()->dropIfExists('contact_channels');
        Capsule::schema()->dropIfExists('addresses');
        Capsule::schema()->dropIfExists('contacts');
    }
};
