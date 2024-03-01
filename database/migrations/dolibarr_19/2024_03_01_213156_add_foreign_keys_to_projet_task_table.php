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
        Schema::table('projet_task', function (Blueprint $table) {
            $table->foreign(['fk_projet'], 'fk_projet_task_fk_projet')->references(['rowid'])->on('projet')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_user_creat'], 'fk_projet_task_fk_user_creat')->references(['rowid'])->on('user')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_user_valid'], 'fk_projet_task_fk_user_valid')->references(['rowid'])->on('user')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projet_task', function (Blueprint $table) {
            $table->dropForeign('fk_projet_task_fk_projet');
            $table->dropForeign('fk_projet_task_fk_user_creat');
            $table->dropForeign('fk_projet_task_fk_user_valid');
        });
    }
};
