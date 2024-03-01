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
        Schema::table('product', function (Blueprint $table) {
            $table->foreign(['fk_barcode_type'], 'fk_product_barcode_type')->references(['rowid'])->on('c_barcode_type')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_default_warehouse'], 'fk_product_default_warehouse')->references(['rowid'])->on('entrepot')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['finished'], 'fk_product_finished')->references(['code'])->on('c_product_nature')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_country'], 'fk_product_fk_country')->references(['rowid'])->on('c_country')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_unit'], 'fk_product_fk_unit')->references(['rowid'])->on('c_units')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->dropForeign('fk_product_barcode_type');
            $table->dropForeign('fk_product_default_warehouse');
            $table->dropForeign('fk_product_finished');
            $table->dropForeign('fk_product_fk_country');
            $table->dropForeign('fk_product_fk_unit');
        });
    }
};
