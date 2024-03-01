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
        Schema::create('product_attribute_combination2val', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_prod_combination');
            $table->integer('fk_prod_attr');
            $table->integer('fk_prod_attr_val');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_attribute_combination2val');
    }
};
