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
        Schema::create('product_pricerules', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('level')->unique('unique_level');
            $table->integer('fk_level');
            $table->double('var_percent');
            $table->double('var_min_percent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_pricerules');
    }
};
