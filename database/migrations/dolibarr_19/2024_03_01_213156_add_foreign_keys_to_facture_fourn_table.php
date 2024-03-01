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
        Schema::table('facture_fourn', function (Blueprint $table) {
            $table->foreign(['fk_projet'], 'fk_facture_fourn_fk_projet')->references(['rowid'])->on('projet')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_soc'], 'fk_facture_fourn_fk_soc')->references(['rowid'])->on('societe')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_user_author'], 'fk_facture_fourn_fk_user_author')->references(['rowid'])->on('user')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_user_valid'], 'fk_facture_fourn_fk_user_valid')->references(['rowid'])->on('user')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facture_fourn', function (Blueprint $table) {
            $table->dropForeign('fk_facture_fourn_fk_projet');
            $table->dropForeign('fk_facture_fourn_fk_soc');
            $table->dropForeign('fk_facture_fourn_fk_user_author');
            $table->dropForeign('fk_facture_fourn_fk_user_valid');
        });
    }
};
