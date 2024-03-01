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
        Schema::create('c_chargesociales', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('libelle', 128)->nullable();
            $table->smallInteger('deductible')->default(0);
            $table->tinyInteger('active')->default(1);
            $table->string('code', 12);
            $table->string('accountancy_code', 32)->nullable();
            $table->integer('fk_pays')->default(1);
            $table->string('module', 32)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_chargesociales');
    }
};
