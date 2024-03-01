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
        Schema::create('subscription', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->dateTime('datec')->nullable();
            $table->integer('fk_adherent')->nullable();
            $table->integer('fk_type')->nullable();
            $table->dateTime('dateadh')->nullable();
            $table->dateTime('datef')->nullable();
            $table->double('subscription', 24, 8)->nullable();
            $table->integer('fk_bank')->nullable();
            $table->integer('fk_user_creat')->nullable();
            $table->integer('fk_user_valid')->nullable();
            $table->text('note')->nullable();

            $table->unique(['fk_adherent', 'dateadh'], 'uk_subscription');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription');
    }
};
