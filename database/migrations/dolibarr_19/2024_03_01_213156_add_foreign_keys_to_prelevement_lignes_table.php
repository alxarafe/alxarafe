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
        Schema::table('prelevement_lignes', function (Blueprint $table) {
            $table->foreign(['fk_prelevement_bons'], 'fk_prelevement_lignes_fk_prelevement_bons')->references(['rowid'])->on('prelevement_bons')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prelevement_lignes', function (Blueprint $table) {
            $table->dropForeign('fk_prelevement_lignes_fk_prelevement_bons');
        });
    }
};
