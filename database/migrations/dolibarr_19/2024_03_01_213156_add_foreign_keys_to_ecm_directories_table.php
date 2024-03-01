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
        Schema::table('ecm_directories', function (Blueprint $table) {
            $table->foreign(['fk_user_c'], 'fk_ecm_directories_fk_user_c')->references(['rowid'])->on('user')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_user_m'], 'fk_ecm_directories_fk_user_m')->references(['rowid'])->on('user')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ecm_directories', function (Blueprint $table) {
            $table->dropForeign('fk_ecm_directories_fk_user_c');
            $table->dropForeign('fk_ecm_directories_fk_user_m');
        });
    }
};
