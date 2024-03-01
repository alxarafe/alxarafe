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
        Schema::table('contratdet', function (Blueprint $table) {
            $table->foreign(['fk_contrat'], 'fk_contratdet_fk_contrat')->references(['rowid'])->on('contrat')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_product'], 'fk_contratdet_fk_product')->references(['rowid'])->on('product')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_unit'], 'fk_contratdet_fk_unit')->references(['rowid'])->on('c_units')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contratdet', function (Blueprint $table) {
            $table->dropForeign('fk_contratdet_fk_contrat');
            $table->dropForeign('fk_contratdet_fk_product');
            $table->dropForeign('fk_contratdet_fk_unit');
        });
    }
};
