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
        Schema::table('commandedet', function (Blueprint $table) {
            $table->foreign(['fk_commande'], 'fk_commandedet_fk_commande')->references(['rowid'])->on('commande')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_commandefourndet'], 'fk_commandedet_fk_commandefourndet')->references(['rowid'])->on('commande_fournisseurdet')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_unit'], 'fk_commandedet_fk_unit')->references(['rowid'])->on('c_units')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commandedet', function (Blueprint $table) {
            $table->dropForeign('fk_commandedet_fk_commande');
            $table->dropForeign('fk_commandedet_fk_commandefourndet');
            $table->dropForeign('fk_commandedet_fk_unit');
        });
    }
};
