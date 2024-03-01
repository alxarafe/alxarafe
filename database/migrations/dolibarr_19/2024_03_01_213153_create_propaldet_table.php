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
        Schema::create('propaldet', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_propal')->index('idx_propaldet_fk_propal');
            $table->integer('fk_parent_line')->nullable();
            $table->integer('fk_product')->nullable()->index('idx_propaldet_fk_product');
            $table->string('label')->nullable();
            $table->text('description')->nullable();
            $table->integer('fk_remise_except')->nullable();
            $table->string('vat_src_code', 10)->nullable()->default('');
            $table->double('tva_tx', 7, 4)->nullable()->default(0);
            $table->double('localtax1_tx', 7, 4)->nullable()->default(0);
            $table->string('localtax1_type', 10)->nullable();
            $table->double('localtax2_tx', 7, 4)->nullable()->default(0);
            $table->string('localtax2_type', 10)->nullable();
            $table->double('qty')->nullable();
            $table->double('remise_percent')->nullable()->default(0);
            $table->double('remise')->nullable()->default(0);
            $table->double('price')->nullable();
            $table->double('subprice', 24, 8)->nullable()->default(0);
            $table->double('total_ht', 24, 8)->nullable()->default(0);
            $table->double('total_tva', 24, 8)->nullable()->default(0);
            $table->double('total_localtax1', 24, 8)->nullable()->default(0);
            $table->double('total_localtax2', 24, 8)->nullable()->default(0);
            $table->double('total_ttc', 24, 8)->nullable()->default(0);
            $table->integer('product_type')->nullable()->default(0);
            $table->dateTime('date_start')->nullable();
            $table->dateTime('date_end')->nullable();
            $table->integer('info_bits')->nullable()->default(0);
            $table->double('buy_price_ht', 24, 8)->nullable()->default(0);
            $table->integer('fk_product_fournisseur_price')->nullable();
            $table->integer('special_code')->nullable()->default(0);
            $table->integer('rang')->nullable()->default(0);
            $table->integer('fk_unit')->nullable()->index('fk_propaldet_fk_unit');
            $table->integer('fk_multicurrency')->nullable();
            $table->string('multicurrency_code', 3)->nullable();
            $table->double('multicurrency_subprice', 24, 8)->nullable()->default(0);
            $table->double('multicurrency_total_ht', 24, 8)->nullable()->default(0);
            $table->double('multicurrency_total_tva', 24, 8)->nullable()->default(0);
            $table->double('multicurrency_total_ttc', 24, 8)->nullable()->default(0);
            $table->string('import_key', 14)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('propaldet');
    }
};
