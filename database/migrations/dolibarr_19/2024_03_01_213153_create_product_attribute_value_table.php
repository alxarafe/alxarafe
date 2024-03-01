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
        Schema::create('product_attribute_value', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_product_attribute');
            $table->string('ref', 180);
            $table->string('value');
            $table->integer('entity')->default(1);
            $table->integer('position')->default(0);

            $table->unique(['fk_product_attribute', 'ref'], 'uk_product_attribute_value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_attribute_value');
    }
};
