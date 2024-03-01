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
        Schema::create('c_input_method', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('code', 30)->nullable()->unique('uk_c_input_method');
            $table->string('libelle', 128)->nullable();
            $table->tinyInteger('active')->default(1);
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
        Schema::dropIfExists('c_input_method');
    }
};
