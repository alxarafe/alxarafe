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
        Schema::create('holiday_logs', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->dateTime('date_action');
            $table->integer('fk_user_action');
            $table->integer('fk_user_update');
            $table->integer('fk_type');
            $table->string('type_action');
            $table->string('prev_solde');
            $table->string('new_solde');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('holiday_logs');
    }
};
