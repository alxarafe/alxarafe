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
        Schema::table('product_price_by_qty', function (Blueprint $table) {
            $table->foreign(['fk_product_price'], 'fk_product_price_by_qty_fk_product_price')->references(['rowid'])->on('product_price')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_price_by_qty', function (Blueprint $table) {
            $table->dropForeign('fk_product_price_by_qty_fk_product_price');
        });
    }
};
