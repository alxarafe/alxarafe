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
        Schema::create('multicurrency_rate', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->dateTime('date_sync')->nullable();
            $table->double('rate')->default(0);
            $table->double('rate_indirect')->nullable()->default(0);
            $table->integer('fk_multicurrency');
            $table->integer('entity')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('multicurrency_rate');
    }
};
