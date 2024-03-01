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
        Schema::table('accounting_account', function (Blueprint $table) {
            $table->foreign(['fk_pcg_version'], 'fk_accounting_account_fk_pcg_version')->references(['pcg_version'])->on('accounting_system')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounting_account', function (Blueprint $table) {
            $table->dropForeign('fk_accounting_account_fk_pcg_version');
        });
    }
};
