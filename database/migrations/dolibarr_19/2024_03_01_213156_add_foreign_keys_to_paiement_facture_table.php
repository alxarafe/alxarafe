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
        Schema::table('paiement_facture', function (Blueprint $table) {
            $table->foreign(['fk_facture'], 'fk_paiement_facture_fk_facture')->references(['rowid'])->on('facture')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_paiement'], 'fk_paiement_facture_fk_paiement')->references(['rowid'])->on('paiement')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paiement_facture', function (Blueprint $table) {
            $table->dropForeign('fk_paiement_facture_fk_facture');
            $table->dropForeign('fk_paiement_facture_fk_paiement');
        });
    }
};
