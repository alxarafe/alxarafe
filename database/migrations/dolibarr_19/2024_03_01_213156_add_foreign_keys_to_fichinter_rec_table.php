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
        Schema::table('fichinter_rec', function (Blueprint $table) {
            $table->foreign(['fk_projet'], 'fk_fichinter_rec_fk_projet')->references(['rowid'])->on('projet')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_user_author'], 'fk_fichinter_rec_fk_user_author')->references(['rowid'])->on('user')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fichinter_rec', function (Blueprint $table) {
            $table->dropForeign('fk_fichinter_rec_fk_projet');
            $table->dropForeign('fk_fichinter_rec_fk_user_author');
        });
    }
};
