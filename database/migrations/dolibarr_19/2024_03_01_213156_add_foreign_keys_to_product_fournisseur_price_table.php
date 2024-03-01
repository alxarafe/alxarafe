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
        Schema::table('product_fournisseur_price', function (Blueprint $table) {
            $table->foreign(['fk_barcode_type'], 'fk_product_fournisseur_price_barcode_type')->references(['rowid'])->on('c_barcode_type')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_product'], 'fk_product_fournisseur_price_fk_product')->references(['rowid'])->on('product')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_user'], 'fk_product_fournisseur_price_fk_user')->references(['rowid'])->on('user')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_fournisseur_price', function (Blueprint $table) {
            $table->dropForeign('fk_product_fournisseur_price_barcode_type');
            $table->dropForeign('fk_product_fournisseur_price_fk_product');
            $table->dropForeign('fk_product_fournisseur_price_fk_user');
        });
    }
};
