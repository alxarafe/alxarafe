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
        Schema::table('facture_fourn_det', function (Blueprint $table) {
            $table->foreign(['fk_facture_fourn'], 'fk_facture_fourn_det_fk_facture')->references(['rowid'])->on('facture_fourn')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_unit'], 'fk_facture_fourn_det_fk_unit')->references(['rowid'])->on('c_units')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facture_fourn_det', function (Blueprint $table) {
            $table->dropForeign('fk_facture_fourn_det_fk_facture');
            $table->dropForeign('fk_facture_fourn_det_fk_unit');
        });
    }
};
