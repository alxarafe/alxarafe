<?php

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Schema\Blueprint;

return new class {
    public function up()
    {
        // Countries reference table
        if (!DB::schema()->hasTable('countries')) {
            DB::schema()->create('countries', function (Blueprint $table) {
                $table->id();
                $table->string('code', 2)->unique(); // ISO 3166-1 alpha-2
                $table->string('name');
                $table->timestamps();
            });

            // Seed some data
            DB::table('countries')->insert([
                ['code' => 'ES', 'name' => 'España', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                ['code' => 'US', 'name' => 'Estados Unidos', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                ['code' => 'FR', 'name' => 'Francia', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                ['code' => 'GB', 'name' => 'Reino Unido', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                ['code' => 'DE', 'name' => 'Alemania', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);
        }

        // Add country_id to people table
        if (DB::schema()->hasTable('people')) {
            if (!DB::schema()->hasColumn('people', 'country_id')) {
                DB::schema()->table('people', function (Blueprint $table) {
                    $table->foreignId('country_id')->nullable()->constrained('countries')->nullOnDelete();
                });
            }
        }
    }

    public function down()
    {
        if (DB::schema()->hasTable('people')) {
            DB::schema()->table('people', function (Blueprint $table) {
                $table->dropForeign(['country_id']);
                $table->dropColumn('country_id');
            });
        }
        DB::schema()->dropIfExists('countries');
    }
};
