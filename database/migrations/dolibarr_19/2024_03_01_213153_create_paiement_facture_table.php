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
        Schema::create('paiement_facture', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_paiement')->nullable()->index('idx_paiement_facture_fk_paiement');
            $table->integer('fk_facture')->nullable()->index('idx_paiement_facture_fk_facture');
            $table->double('amount', 24, 8)->nullable()->default(0);
            $table->string('multicurrency_code', 3)->nullable();
            $table->double('multicurrency_tx', 24, 8)->nullable()->default(1);
            $table->double('multicurrency_amount', 24, 8)->nullable()->default(0);

            $table->unique(['fk_paiement', 'fk_facture'], 'uk_paiement_facture');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paiement_facture');
    }
};
