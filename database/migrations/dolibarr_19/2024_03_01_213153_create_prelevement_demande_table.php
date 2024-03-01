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
        Schema::create('prelevement_demande', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(1);
            $table->integer('fk_facture')->nullable()->index('idx_prelevement_demande_fk_facture');
            $table->integer('fk_facture_fourn')->nullable()->index('idx_prelevement_demande_fk_facture_fourn');
            $table->integer('fk_salary')->nullable();
            $table->string('sourcetype', 32)->nullable();
            $table->double('amount', 24, 8);
            $table->dateTime('date_demande');
            $table->smallInteger('traite')->nullable()->default(0);
            $table->dateTime('date_traite')->nullable();
            $table->integer('fk_prelevement_bons')->nullable();
            $table->integer('fk_user_demande');
            $table->string('code_banque', 128)->nullable();
            $table->string('code_guichet', 6)->nullable();
            $table->string('number')->nullable();
            $table->string('cle_rib', 5)->nullable();
            $table->string('type', 12)->nullable()->default('');
            $table->string('ext_payment_id')->nullable()->index('idx_prelevement_demande_ext_payment_id');
            $table->string('ext_payment_site', 128)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prelevement_demande');
    }
};
