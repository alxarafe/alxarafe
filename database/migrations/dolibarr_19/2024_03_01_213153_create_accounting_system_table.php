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
        Schema::create('accounting_system', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_country')->nullable();
            $table->string('pcg_version', 32)->unique('uk_accounting_system_pcg_version');
            $table->string('label', 128);
            $table->smallInteger('active')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounting_system');
    }
};
