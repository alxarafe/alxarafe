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
        Schema::create('product_attribute_combination', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_product_parent')->index('idx_product_att_com_product_parent');
            $table->integer('fk_product_child')->index('idx_product_att_com_product_child');
            $table->double('variation_price', 24, 8);
            $table->integer('variation_price_percentage')->nullable();
            $table->double('variation_weight');
            $table->string('variation_ref_ext')->nullable();
            $table->integer('entity')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_attribute_combination');
    }
};
