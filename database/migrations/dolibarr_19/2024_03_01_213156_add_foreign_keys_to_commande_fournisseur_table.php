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
        Schema::table('commande_fournisseur', function (Blueprint $table) {
            $table->foreign(['fk_soc'], 'fk_commande_fournisseur_fk_soc')->references(['rowid'])->on('societe')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commande_fournisseur', function (Blueprint $table) {
            $table->dropForeign('fk_commande_fournisseur_fk_soc');
        });
    }
};
