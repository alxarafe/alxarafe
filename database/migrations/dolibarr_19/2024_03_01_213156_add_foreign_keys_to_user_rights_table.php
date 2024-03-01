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
        Schema::table('user_rights', function (Blueprint $table) {
            $table->foreign(['fk_user'], 'fk_user_rights_fk_user_user')->references(['rowid'])->on('user')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_rights', function (Blueprint $table) {
            $table->dropForeign('fk_user_rights_fk_user_user');
        });
    }
};
