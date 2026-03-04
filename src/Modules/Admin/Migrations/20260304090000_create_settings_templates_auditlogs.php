<?php

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
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
        if (!Database::schema()->hasTable('settings')) {
            Database::schema()->create('settings', function (Blueprint $table) {
                $table->id();
                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->timestamps();
            });
        }

        if (!Database::schema()->hasTable('email_templates')) {
            Database::schema()->create('email_templates', function (Blueprint $table) {
                $table->id();
                $table->string('code', 100)->unique();
                $table->string('subject', 255);
                $table->text('body');
                $table->text('variables')->nullable(); // JSON array of variable names
                $table->boolean('active')->default(true);
                $table->timestamps();
            });
        }

        if (!Database::schema()->hasTable('audit_logs')) {
            Database::schema()->create('audit_logs', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedInteger('user_id')->nullable();
                $table->string('model_type');
                $table->string('model_id', 36);
                $table->enum('action', ['created', 'updated', 'deleted']);
                $table->json('old_values')->nullable();
                $table->json('new_values')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->timestamp('created_at')->useCurrent();

                $table->index(['model_type', 'model_id'], 'idx_audit_model');
                $table->index('user_id', 'idx_audit_user');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Database::schema()->dropIfExists('audit_logs');
        Database::schema()->dropIfExists('email_templates');
        Database::schema()->dropIfExists('settings');
    }
};
