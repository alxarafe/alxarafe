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
        Schema::table('socpeople', function (Blueprint $table) {
            $table->foreign(['fk_soc'], 'fk_socpeople_fk_soc')->references(['rowid'])->on('societe')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_user_creat'], 'fk_socpeople_user_creat_user_rowid')->references(['rowid'])->on('user')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('socpeople', function (Blueprint $table) {
            $table->dropForeign('fk_socpeople_fk_soc');
            $table->dropForeign('fk_socpeople_user_creat_user_rowid');
        });
    }
};
