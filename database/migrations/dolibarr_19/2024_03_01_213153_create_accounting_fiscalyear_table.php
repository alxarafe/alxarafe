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
        Schema::create('accounting_fiscalyear', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('label', 128);
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            $table->tinyInteger('statut')->default(0);
            $table->integer('entity')->default(1);
            $table->dateTime('datec');
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_user_author')->nullable();
            $table->integer('fk_user_modif')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounting_fiscalyear');
    }
};
