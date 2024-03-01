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
        Schema::create('product_stock', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_product')->index('idx_product_stock_fk_product');
            $table->integer('fk_entrepot')->index('idx_product_stock_fk_entrepot');
            $table->double('reel')->nullable();
            $table->string('import_key', 14)->nullable();

            $table->unique(['fk_product', 'fk_entrepot'], 'uk_product_stock');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_stock');
    }
};
