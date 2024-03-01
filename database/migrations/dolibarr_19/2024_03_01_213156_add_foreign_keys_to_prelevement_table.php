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
        Schema::table('prelevement', function (Blueprint $table) {
            $table->foreign(['fk_prelevement_lignes'], 'fk_prelevement_fk_prelevement_lignes')->references(['rowid'])->on('prelevement_lignes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prelevement', function (Blueprint $table) {
            $table->dropForeign('fk_prelevement_fk_prelevement_lignes');
        });
    }
};
