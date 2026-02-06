<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up(): void
    {
        if (!Capsule::schema()->hasTable('people')) {
            Capsule::schema()->create('people', function (Blueprint $table) {
                $table->id();
                $table->string('name', 25);
                $table->string('lastname', 25);
                $table->boolean('active')->default(true);
                $table->date('birth_date')->nullable();
                $table->text('observations')->nullable();
                $table->timestamps();
            });
        }

        if (!Capsule::schema()->hasTable('addresses')) {
            Capsule::schema()->create('addresses', function (Blueprint $table) {
                $table->id();
                $table->string('street');
                $table->string('city');
                $table->string('zip');
                $table->foreignId('person_id')->constrained('people')->onDelete('cascade');
                $table->timestamps();
            });
        }

        if (!Capsule::schema()->hasTable('phones')) {
            Capsule::schema()->create('phones', function (Blueprint $table) {
                $table->id();
                $table->string('number');
                $table->string('type')->nullable();
                $table->foreignId('person_id')->constrained('people')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Capsule::schema()->dropIfExists('phones');
        Capsule::schema()->dropIfExists('addresses');
        Capsule::schema()->dropIfExists('people');
    }
};
