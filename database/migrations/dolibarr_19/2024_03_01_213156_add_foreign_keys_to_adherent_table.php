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
        Schema::table('adherent', function (Blueprint $table) {
            $table->foreign(['fk_soc'], 'adherent_fk_soc')->references(['rowid'])->on('societe')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_adherent_type'], 'fk_adherent_adherent_type')->references(['rowid'])->on('adherent_type')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adherent', function (Blueprint $table) {
            $table->dropForeign('adherent_fk_soc');
            $table->dropForeign('fk_adherent_adherent_type');
        });
    }
};
