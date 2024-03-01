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
        Schema::create('inventorydet', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->dateTime('datec')->nullable()->index('idx_inventorydet_datec');
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent()->index('idx_inventorydet_tms');
            $table->integer('fk_inventory')->nullable()->default(0)->index('idx_inventorydet_fk_inventory');
            $table->integer('fk_warehouse')->nullable()->default(0);
            $table->integer('fk_product')->nullable()->default(0);
            $table->string('batch', 128)->nullable();
            $table->double('qty_stock')->nullable();
            $table->double('qty_view')->nullable();
            $table->double('qty_regulated')->nullable();
            $table->double('pmp_real')->nullable();
            $table->double('pmp_expected')->nullable();
            $table->integer('fk_movement')->nullable();

            $table->unique(['fk_inventory', 'fk_warehouse', 'fk_product', 'batch'], 'uk_inventorydet');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventorydet');
    }
};
