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
        Schema::create('paiementcharge', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_charge')->nullable();
            $table->dateTime('datec')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->dateTime('datep')->nullable();
            $table->double('amount', 24, 8)->nullable()->default(0);
            $table->integer('fk_typepaiement');
            $table->string('num_paiement', 50)->nullable();
            $table->text('note')->nullable();
            $table->integer('fk_bank');
            $table->integer('fk_user_creat')->nullable();
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
        Schema::dropIfExists('paiementcharge');
    }
};
