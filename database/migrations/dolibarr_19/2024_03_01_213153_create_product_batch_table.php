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
        Schema::create('product_batch', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_product_stock')->index('idx_fk_product_stock');
            $table->dateTime('eatby')->nullable();
            $table->dateTime('sellby')->nullable();
            $table->string('batch', 128)->index('idx_batch');
            $table->double('qty')->default(0);
            $table->string('import_key', 14)->nullable();

            $table->unique(['fk_product_stock', 'batch'], 'uk_product_batch');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_batch');
    }
};
