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
        Schema::create('product_fournisseur_price', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(1);
            $table->dateTime('datec')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_product')->nullable();
            $table->integer('fk_soc')->nullable();
            $table->string('ref_fourn', 128)->nullable();
            $table->text('desc_fourn')->nullable();
            $table->integer('fk_availability')->nullable();
            $table->double('price', 24, 8)->nullable()->default(0);
            $table->double('quantity')->nullable();
            $table->double('remise_percent')->default(0);
            $table->double('remise')->default(0);
            $table->double('unitprice', 24, 8)->nullable()->default(0);
            $table->double('charges', 24, 8)->nullable()->default(0);
            $table->string('default_vat_code', 10)->nullable();
            $table->string('barcode', 180)->nullable()->index('idx_product_barcode');
            $table->integer('fk_barcode_type')->nullable()->index('idx_product_fk_barcode_type');
            $table->double('tva_tx', 7, 4);
            $table->double('localtax1_tx', 7, 4)->nullable()->default(0);
            $table->string('localtax1_type', 10)->default('0');
            $table->double('localtax2_tx', 7, 4)->nullable()->default(0);
            $table->string('localtax2_type', 10)->default('0');
            $table->integer('info_bits')->default(0);
            $table->integer('fk_user')->nullable()->index('idx_product_fournisseur_price_fk_user');
            $table->integer('fk_supplier_price_expression')->nullable();
            $table->integer('delivery_time_days')->nullable();
            $table->string('supplier_reputation', 10)->nullable();
            $table->double('packaging')->nullable();
            $table->integer('fk_multicurrency')->nullable();
            $table->string('multicurrency_code', 3)->nullable();
            $table->double('multicurrency_tx', 24, 8)->nullable()->default(1);
            $table->double('multicurrency_unitprice', 24, 8)->nullable();
            $table->double('multicurrency_price', 24, 8)->nullable();
            $table->string('import_key', 14)->nullable();
            $table->integer('status')->nullable()->default(1);

            $table->index(['fk_product', 'entity'], 'idx_product_fourn_price_fk_product');
            $table->index(['fk_soc', 'entity'], 'idx_product_fourn_price_fk_soc');
            $table->unique(['barcode', 'fk_barcode_type', 'entity'], 'uk_product_barcode');
            $table->unique(['ref_fourn', 'fk_soc', 'quantity', 'entity'], 'uk_product_fournisseur_price_ref');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_fournisseur_price');
    }
};
