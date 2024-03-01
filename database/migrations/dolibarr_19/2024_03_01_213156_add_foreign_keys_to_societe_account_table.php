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
        Schema::table('societe_account', function (Blueprint $table) {
            $table->foreign(['fk_soc'], 'llx_societe_account_fk_societe')->references(['rowid'])->on('societe')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('societe_account', function (Blueprint $table) {
            $table->dropForeign('llx_societe_account_fk_societe');
        });
    }
};
