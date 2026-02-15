<?php

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
