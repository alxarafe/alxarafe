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
        Schema::create('product_fournisseur_price_log', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->dateTime('datec')->nullable();
            $table->integer('fk_product_fournisseur')->index('idx_product_fournisseur_price_log_fk_product_fournisseur');
            $table->double('price', 24, 8)->nullable()->default(0);
            $table->double('quantity')->nullable();
            $table->integer('fk_user')->nullable()->index('idx_product_fournisseur_price_log_fk_user');
            $table->integer('fk_multicurrency')->nullable();
            $table->string('multicurrency_code', 3)->nullable();
            $table->double('multicurrency_tx', 24, 8)->nullable()->default(1);
            $table->double('multicurrency_unitprice', 24, 8)->nullable();
            $table->double('multicurrency_price', 24, 8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_fournisseur_price_log');
    }
};
