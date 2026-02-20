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
        // 1. Roles Table
        if (!Database::schema()->hasTable('roles')) {
            Database::schema()->create('roles', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->string('description')->nullable();
                $table->boolean('active')->default(true);
                $table->timestamps();
            });
        }

        // 2. Permissions Table (With Soft Deletes for Module Uninstallation)
        if (!Database::schema()->hasTable('permissions')) {
            Database::schema()->create('permissions', function (Blueprint $table) {
                $table->id();
                $table->string('module');
                $table->string('controller');
                $table->string('action');
                $table->string('name')->nullable(); // Human readable name (optional)
                $table->timestamps();
                $table->softDeletes(); // For when a module is disabled but restored later

                // Unique constraint to prevent duplicates
                $table->unique(['module', 'controller', 'action']);
            });
        }

        // 3. Role-Permissions Pivot Table
        if (!Database::schema()->hasTable('role_permissions')) {
            Database::schema()->create('role_permissions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
                $table->foreignId('permission_id')->constrained('permissions')->onDelete('cascade');

                $table->unique(['role_id', 'permission_id']);
            });
        }

        // 4. Update Users Table (Add role_id and is_admin)
        if (Database::schema()->hasTable('users')) {
            Database::schema()->table('users', function (Blueprint $table) {
                if (!Database::schema()->hasColumn('users', 'role_id')) {
                    $table->foreignId('role_id')->nullable()->constrained('roles')->nullOnDelete();
                }
                if (!Database::schema()->hasColumn('users', 'is_admin')) {
                    $table->boolean('is_admin')->default(false)->after('password');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop pivot first
        Database::schema()->dropIfExists('role_permissions');
        // Drop permissions
        Database::schema()->dropIfExists('permissions');

        // Remove columns from users
        if (Database::schema()->hasTable('users')) {
            Database::schema()->table('users', function (Blueprint $table) {
                if (Database::schema()->hasColumn('users', 'role_id')) {
                    // We avoid dropping the foreign key explicitly by name because it's hard to guess,
                    // but SQLite/MySQL handle simple column drops differently.
                    // For safety in this environment, we just drop the column.
                    $table->dropColumn('role_id');
                }
                if (Database::schema()->hasColumn('users', 'is_admin')) {
                    $table->dropColumn('is_admin');
                }
            });
        }

        // Drop roles last
        Database::schema()->dropIfExists('roles');
    }
};
