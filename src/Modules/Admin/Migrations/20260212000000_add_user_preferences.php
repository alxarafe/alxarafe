<?php

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
