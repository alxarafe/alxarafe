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
        Schema::create('product_attribute_combination_price_level', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_product_attribute_combination')->default(1);
            $table->integer('fk_price_level')->default(1);
            $table->double('variation_price', 24, 8);
            $table->integer('variation_price_percentage')->nullable();

            $table->unique(['fk_product_attribute_combination', 'fk_price_level'], 'uk_prod_att_comb_price_level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_attribute_combination_price_level');
    }
};
