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
        Schema::table('usergroup_rights', function (Blueprint $table) {
            $table->foreign(['fk_usergroup'], 'fk_usergroup_rights_fk_usergroup')->references(['rowid'])->on('usergroup')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('usergroup_rights', function (Blueprint $table) {
            $table->dropForeign('fk_usergroup_rights_fk_usergroup');
        });
    }
};
