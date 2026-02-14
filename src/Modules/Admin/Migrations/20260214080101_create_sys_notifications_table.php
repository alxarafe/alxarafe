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
        if (!Capsule::schema()->hasTable('sys_notifications')) {
            Capsule::schema()->create('sys_notifications', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->comment('Null for global notification')->index();
                $table->string('type')->default('info'); // info, success, warning, error
                $table->text('message');
                $table->string('link')->nullable();
                $table->boolean('read')->default(false);
                $table->timestamp('read_at')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Capsule::schema()->dropIfExists('sys_notifications');
    }
};
