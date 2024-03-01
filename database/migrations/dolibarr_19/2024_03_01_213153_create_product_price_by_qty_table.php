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
        Schema::create('product_price_by_qty', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_product_price')->index('idx_product_price_by_qty_fk_product_price');
            $table->double('price', 24, 8)->nullable()->default(0);
            $table->string('price_base_type', 3)->nullable()->default('HT');
            $table->double('quantity')->nullable();
            $table->double('remise_percent')->default(0);
            $table->double('remise')->default(0);
            $table->double('unitprice', 24, 8)->nullable()->default(0);
            $table->integer('fk_user_creat')->nullable();
            $table->integer('fk_user_modif')->nullable();
            $table->integer('fk_multicurrency')->nullable();
            $table->string('multicurrency_code', 3)->nullable();
            $table->double('multicurrency_tx', 24, 8)->nullable()->default(1);
            $table->double('multicurrency_price', 24, 8)->nullable();
            $table->double('multicurrency_price_ttc', 24, 8)->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->string('import_key', 14)->nullable();

            $table->unique(['fk_product_price', 'quantity'], 'uk_product_price_by_qty_level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_price_by_qty');
    }
};
