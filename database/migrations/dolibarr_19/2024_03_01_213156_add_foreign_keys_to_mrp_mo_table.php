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
        Schema::table('mrp_mo', function (Blueprint $table) {
            $table->foreign(['fk_user_creat'], 'fk_mrp_mo_fk_user_creat')->references(['rowid'])->on('user')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mrp_mo', function (Blueprint $table) {
            $table->dropForeign('fk_mrp_mo_fk_user_creat');
        });
    }
};
