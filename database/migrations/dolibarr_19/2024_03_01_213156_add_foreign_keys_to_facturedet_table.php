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
        Schema::table('facturedet', function (Blueprint $table) {
            $table->foreign(['fk_facture'], 'fk_facturedet_fk_facture')->references(['rowid'])->on('facture')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_unit'], 'fk_facturedet_fk_unit')->references(['rowid'])->on('c_units')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facturedet', function (Blueprint $table) {
            $table->dropForeign('fk_facturedet_fk_facture');
            $table->dropForeign('fk_facturedet_fk_unit');
        });
    }
};
