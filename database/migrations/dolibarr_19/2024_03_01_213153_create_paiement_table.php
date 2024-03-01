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
        Schema::create('paiement', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('ref', 30)->nullable();
            $table->string('ref_ext')->nullable();
            $table->integer('entity')->default(1);
            $table->dateTime('datec')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->dateTime('datep')->nullable();
            $table->double('amount', 24, 8)->nullable()->default(0);
            $table->double('multicurrency_amount', 24, 8)->nullable()->default(0);
            $table->integer('fk_paiement');
            $table->string('num_paiement', 50)->nullable();
            $table->text('note')->nullable();
            $table->string('ext_payment_id')->nullable();
            $table->string('ext_payment_site', 128)->nullable();
            $table->integer('fk_bank')->default(0);
            $table->integer('fk_user_creat')->nullable();
            $table->integer('fk_user_modif')->nullable();
            $table->smallInteger('statut')->default(0);
            $table->integer('fk_export_compta')->default(0);
            $table->double('pos_change', 24, 8)->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paiement');
    }
};
