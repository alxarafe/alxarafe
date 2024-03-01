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
        Schema::create('c_actioncomm', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('code', 50)->unique('uk_c_actioncomm');
            $table->string('type', 50)->default('system');
            $table->string('libelle', 128);
            $table->string('module', 50)->nullable();
            $table->tinyInteger('active')->default(1);
            $table->tinyInteger('todo')->nullable();
            $table->string('color', 9)->nullable();
            $table->string('picto', 48)->nullable();
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
        Schema::dropIfExists('c_actioncomm');
    }
};
