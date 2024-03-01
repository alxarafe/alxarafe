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
        Schema::create('societe_remise_except', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(1);
            $table->integer('fk_soc')->index('idx_societe_remise_except_fk_soc');
            $table->integer('discount_type')->default(0)->index('idx_societe_remise_except_discount_type');
            $table->dateTime('datec')->nullable();
            $table->double('amount_ht', 24, 8);
            $table->double('amount_tva', 24, 8)->default(0);
            $table->double('amount_ttc', 24, 8)->default(0);
            $table->double('tva_tx', 7, 4)->default(0);
            $table->string('vat_src_code', 10)->nullable()->default('');
            $table->integer('fk_user')->index('idx_societe_remise_except_fk_user');
            $table->integer('fk_facture_line')->nullable()->index('idx_societe_remise_except_fk_facture_line');
            $table->integer('fk_facture')->nullable()->index('idx_societe_remise_except_fk_facture');
            $table->integer('fk_facture_source')->nullable()->index('idx_societe_remise_except_fk_facture_source');
            $table->integer('fk_invoice_supplier_line')->nullable()->index('fk_soc_remise_fk_invoice_supplier_line');
            $table->integer('fk_invoice_supplier')->nullable()->index('fk_societe_remise_fk_invoice_supplier_source');
            $table->integer('fk_invoice_supplier_source')->nullable();
            $table->text('description');
            $table->string('multicurrency_code', 3)->nullable();
            $table->double('multicurrency_tx', 24, 8)->nullable();
            $table->double('multicurrency_amount_ht', 24, 8)->default(0);
            $table->double('multicurrency_amount_tva', 24, 8)->default(0);
            $table->double('multicurrency_amount_ttc', 24, 8)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('societe_remise_except');
    }
};
