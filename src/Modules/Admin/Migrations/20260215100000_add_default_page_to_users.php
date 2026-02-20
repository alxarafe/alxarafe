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
        if (Capsule::schema()->hasTable('users')) {
            Capsule::schema()->table('users', function (Blueprint $table) {
                if (!Capsule::schema()->hasColumn('users', 'default_page')) {
                    $table->string('default_page')->nullable()->after('theme');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Capsule::schema()->hasTable('users')) {
            Capsule::schema()->table('users', function (Blueprint $table) {
                if (Capsule::schema()->hasColumn('users', 'default_page')) {
                    $table->dropColumn('default_page');
                }
            });
        }
    }
};
