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
        Schema::create('notify', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->dateTime('daten')->nullable();
            $table->integer('fk_action');
            $table->integer('fk_soc')->nullable();
            $table->integer('fk_contact')->nullable();
            $table->integer('fk_user')->nullable();
            $table->string('type', 16)->nullable()->default('email');
            $table->string('type_target', 16)->nullable();
            $table->string('objet_type', 24);
            $table->integer('objet_id');
            $table->string('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notify');
    }
};
