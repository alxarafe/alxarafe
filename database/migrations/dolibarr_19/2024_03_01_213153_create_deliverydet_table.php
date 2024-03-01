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
        Schema::create('deliverydet', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_delivery')->nullable()->index('idx_deliverydet_fk_delivery');
            $table->integer('fk_origin_line')->nullable();
            $table->integer('fk_product')->nullable();
            $table->text('description')->nullable();
            $table->double('qty')->nullable();
            $table->double('subprice', 24, 8)->nullable()->default(0);
            $table->double('total_ht', 24, 8)->nullable()->default(0);
            $table->integer('rang')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deliverydet');
    }
};
