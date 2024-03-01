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
        Schema::table('fichinter', function (Blueprint $table) {
            $table->foreign(['fk_soc'], 'fk_fichinter_fk_soc')->references(['rowid'])->on('societe')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fichinter', function (Blueprint $table) {
            $table->dropForeign('fk_fichinter_fk_soc');
        });
    }
};
