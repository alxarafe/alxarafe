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
        Schema::table('fichinterdet', function (Blueprint $table) {
            $table->foreign(['fk_fichinter'], 'fk_fichinterdet_fk_fichinter')->references(['rowid'])->on('fichinter')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fichinterdet', function (Blueprint $table) {
            $table->dropForeign('fk_fichinterdet_fk_fichinter');
        });
    }
};
