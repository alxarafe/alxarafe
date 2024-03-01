<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holiday_users', function (Blueprint $table) {
            $table->integer('fk_user');
            $table->integer('fk_type');
            $table->double('nb_holiday')->default(0);

            $table->unique(['fk_user', 'fk_type'], 'uk_holiday_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('holiday_users');
    }
};
