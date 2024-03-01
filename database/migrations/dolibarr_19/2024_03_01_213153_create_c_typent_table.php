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
        Schema::create('c_typent', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('code', 12)->unique('uk_c_typent');
            $table->string('libelle', 128)->nullable();
            $table->integer('fk_country')->nullable();
            $table->tinyInteger('active')->default(1);
            $table->string('module', 32)->nullable();
            $table->integer('position')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_typent');
    }
};
