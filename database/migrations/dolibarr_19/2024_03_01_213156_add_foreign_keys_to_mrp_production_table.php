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
        Schema::table('mrp_production', function (Blueprint $table) {
            $table->foreign(['fk_mo'], 'fk_mrp_production_mo')->references(['rowid'])->on('mrp_mo')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_product'], 'fk_mrp_production_product')->references(['rowid'])->on('product')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_stock_movement'], 'fk_mrp_production_stock_movement')->references(['rowid'])->on('stock_mouvement')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mrp_production', function (Blueprint $table) {
            $table->dropForeign('fk_mrp_production_mo');
            $table->dropForeign('fk_mrp_production_product');
            $table->dropForeign('fk_mrp_production_stock_movement');
        });
    }
};
