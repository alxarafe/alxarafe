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
        Schema::create('c_revenuestamp', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_pays');
            $table->double('taux');
            $table->string('revenuestamp_type', 16)->default('fixed');
            $table->string('note', 128)->nullable();
            $table->tinyInteger('active')->default(1);
            $table->string('accountancy_code_sell', 32)->nullable();
            $table->string('accountancy_code_buy', 32)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_revenuestamp');
    }
};
