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
        Schema::table('product_stock', function (Blueprint $table) {
            $table->foreign(['fk_entrepot'], 'fk_entrepot_entrepot_rowid')->references(['rowid'])->on('entrepot')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_product'], 'fk_product_product_rowid')->references(['rowid'])->on('product')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_stock', function (Blueprint $table) {
            $table->dropForeign('fk_entrepot_entrepot_rowid');
            $table->dropForeign('fk_product_product_rowid');
        });
    }
};
