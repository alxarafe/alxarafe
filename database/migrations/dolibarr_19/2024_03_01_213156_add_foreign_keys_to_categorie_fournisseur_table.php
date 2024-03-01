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
        Schema::table('categorie_fournisseur', function (Blueprint $table) {
            $table->foreign(['fk_categorie'], 'fk_categorie_fournisseur_categorie_rowid')->references(['rowid'])->on('categorie')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_soc'], 'fk_categorie_fournisseur_fk_soc')->references(['rowid'])->on('societe')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categorie_fournisseur', function (Blueprint $table) {
            $table->dropForeign('fk_categorie_fournisseur_categorie_rowid');
            $table->dropForeign('fk_categorie_fournisseur_fk_soc');
        });
    }
};
