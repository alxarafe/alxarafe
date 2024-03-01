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
        Schema::create('c_exp_tax_range', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_c_exp_tax_cat')->default(1);
            $table->double('range_ik')->default(0);
            $table->integer('entity')->default(1);
            $table->integer('active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_exp_tax_range');
    }
};
