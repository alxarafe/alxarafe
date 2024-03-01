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
        Schema::table('c_ziptown', function (Blueprint $table) {
            $table->foreign(['fk_county'], 'fk_c_ziptown_fk_county')->references(['rowid'])->on('c_departements')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_pays'], 'fk_c_ziptown_fk_pays')->references(['rowid'])->on('c_country')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('c_ziptown', function (Blueprint $table) {
            $table->dropForeign('fk_c_ziptown_fk_county');
            $table->dropForeign('fk_c_ziptown_fk_pays');
        });
    }
};
