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
        Schema::create('usergroup_user', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(1);
            $table->integer('fk_user')->index('fk_usergroup_user_fk_user');
            $table->integer('fk_usergroup')->index('fk_usergroup_user_fk_usergroup');

            $table->unique(['entity', 'fk_user', 'fk_usergroup'], 'uk_usergroup_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usergroup_user');
    }
};
