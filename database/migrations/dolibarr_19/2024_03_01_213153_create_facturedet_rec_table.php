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
        Schema::create('facturedet_rec', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_facture');
            $table->integer('fk_parent_line')->nullable();
            $table->integer('fk_product')->nullable();
            $table->integer('product_type')->nullable()->default(0);
            $table->string('label')->nullable();
            $table->text('description')->nullable();
            $table->string('vat_src_code', 10)->nullable()->default('');
            $table->double('tva_tx', 7, 4)->nullable();
            $table->double('localtax1_tx', 7, 4)->nullable()->default(0);
            $table->string('localtax1_type', 10)->nullable();
            $table->double('localtax2_tx', 7, 4)->nullable()->default(0);
            $table->string('localtax2_type', 10)->nullable();
            $table->double('qty')->nullable();
            $table->double('remise_percent')->nullable()->default(0);
            $table->double('remise')->nullable()->default(0);
            $table->double('subprice', 24, 8)->nullable();
            $table->double('price', 24, 8)->nullable();
            $table->double('total_ht', 24, 8)->nullable();
            $table->double('total_tva', 24, 8)->nullable();
            $table->double('total_localtax1', 24, 8)->nullable()->default(0);
            $table->double('total_localtax2', 24, 8)->nullable()->default(0);
            $table->double('total_ttc', 24, 8)->nullable();
            $table->integer('date_start_fill')->nullable()->default(0);
            $table->integer('date_end_fill')->nullable()->default(0);
            $table->integer('info_bits')->nullable()->default(0);
            $table->double('buy_price_ht', 24, 8)->nullable()->default(0);
            $table->integer('fk_product_fournisseur_price')->nullable();
            $table->unsignedInteger('special_code')->nullable()->default(0);
            $table->integer('rang')->nullable()->default(0);
            $table->integer('fk_contract_line')->nullable();
            $table->integer('fk_unit')->nullable()->index('fk_facturedet_rec_fk_unit');
            $table->string('import_key', 14)->nullable();
            $table->integer('fk_user_author')->nullable();
            $table->integer('fk_user_modif')->nullable();
            $table->integer('fk_multicurrency')->nullable();
            $table->string('multicurrency_code', 3)->nullable();
            $table->double('multicurrency_subprice', 24, 8)->nullable()->default(0);
            $table->double('multicurrency_total_ht', 24, 8)->nullable()->default(0);
            $table->double('multicurrency_total_tva', 24, 8)->nullable()->default(0);
            $table->double('multicurrency_total_ttc', 24, 8)->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facturedet_rec');
    }
};
