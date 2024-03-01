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
        Schema::create('societe_prices', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_soc')->nullable()->default(0);
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->dateTime('datec')->nullable();
            $table->integer('fk_user_author')->nullable();
            $table->tinyInteger('price_level')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('societe_prices');
    }
};
