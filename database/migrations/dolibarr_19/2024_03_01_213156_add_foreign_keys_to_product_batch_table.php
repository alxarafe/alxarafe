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
        Schema::table('product_batch', function (Blueprint $table) {
            $table->foreign(['fk_product_stock'], 'fk_product_batch_fk_product_stock')->references(['rowid'])->on('product_stock')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_batch', function (Blueprint $table) {
            $table->dropForeign('fk_product_batch_fk_product_stock');
        });
    }
};
