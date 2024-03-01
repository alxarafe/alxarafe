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
        Schema::table('societe_remise_except', function (Blueprint $table) {
            $table->foreign(['fk_facture'], 'fk_societe_remise_fk_facture')->references(['rowid'])->on('facture')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_facture_source'], 'fk_societe_remise_fk_facture_source')->references(['rowid'])->on('facture')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_invoice_supplier'], 'fk_societe_remise_fk_invoice_supplier')->references(['rowid'])->on('facture_fourn')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_invoice_supplier'], 'fk_societe_remise_fk_invoice_supplier_source')->references(['rowid'])->on('facture_fourn')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_user'], 'fk_societe_remise_fk_user')->references(['rowid'])->on('user')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_facture_line'], 'fk_soc_remise_fk_facture_line')->references(['rowid'])->on('facturedet')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_invoice_supplier_line'], 'fk_soc_remise_fk_invoice_supplier_line')->references(['rowid'])->on('facture_fourn_det')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_soc'], 'fk_soc_remise_fk_soc')->references(['rowid'])->on('societe')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('societe_remise_except', function (Blueprint $table) {
            $table->dropForeign('fk_societe_remise_fk_facture');
            $table->dropForeign('fk_societe_remise_fk_facture_source');
            $table->dropForeign('fk_societe_remise_fk_invoice_supplier');
            $table->dropForeign('fk_societe_remise_fk_invoice_supplier_source');
            $table->dropForeign('fk_societe_remise_fk_user');
            $table->dropForeign('fk_soc_remise_fk_facture_line');
            $table->dropForeign('fk_soc_remise_fk_invoice_supplier_line');
            $table->dropForeign('fk_soc_remise_fk_soc');
        });
    }
};
