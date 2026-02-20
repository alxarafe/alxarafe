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

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Alxarafe\Base\Database;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Database::schema()->hasTable('users')) {
            Database::schema()->table('users', function (Blueprint $table) {
                if (!Database::schema()->hasColumn('users', 'language')) {
                    $table->string('language')->nullable()->after('remember_token');
                }
                if (!Database::schema()->hasColumn('users', 'timezone')) {
                    $table->string('timezone')->nullable()->after('language');
                }
                if (!Database::schema()->hasColumn('users', 'theme')) {
                    $table->string('theme')->nullable()->after('timezone');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Database::schema()->hasTable('users')) {
            Database::schema()->table('users', function (Blueprint $table) {
                if (Database::schema()->hasColumn('users', 'theme')) {
                    $table->dropColumn('theme');
                }
                if (Database::schema()->hasColumn('users', 'timezone')) {
                    $table->dropColumn('timezone');
                }
                if (Database::schema()->hasColumn('users', 'language')) {
                    $table->dropColumn('language');
                }
            });
        }
    }
};
