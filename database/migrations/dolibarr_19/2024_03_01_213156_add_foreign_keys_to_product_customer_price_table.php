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
        Schema::table('product_customer_price', function (Blueprint $table) {
            $table->foreign(['fk_product'], 'fk_product_customer_price_fk_product')->references(['rowid'])->on('product')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_soc'], 'fk_product_customer_price_fk_soc')->references(['rowid'])->on('societe')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_user'], 'fk_product_customer_price_fk_user')->references(['rowid'])->on('user')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_customer_price', function (Blueprint $table) {
            $table->dropForeign('fk_product_customer_price_fk_product');
            $table->dropForeign('fk_product_customer_price_fk_soc');
            $table->dropForeign('fk_product_customer_price_fk_user');
        });
    }
};
