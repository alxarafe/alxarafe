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
        Schema::create('establishment', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(1);
            $table->string('ref', 30)->nullable();
            $table->string('label');
            $table->string('name', 128)->nullable();
            $table->string('address')->nullable();
            $table->string('zip', 25)->nullable();
            $table->string('town', 50)->nullable();
            $table->integer('fk_state')->nullable()->default(0);
            $table->integer('fk_country')->nullable()->default(0);
            $table->string('profid1', 20)->nullable();
            $table->string('profid2', 20)->nullable();
            $table->string('profid3', 20)->nullable();
            $table->string('phone', 20)->nullable();
            $table->integer('fk_user_author');
            $table->integer('fk_user_mod')->nullable();
            $table->dateTime('datec');
            $table->timestamp('tms')->useCurrentOnUpdate()->useCurrent();
            $table->tinyInteger('status')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('establishment');
    }
};
