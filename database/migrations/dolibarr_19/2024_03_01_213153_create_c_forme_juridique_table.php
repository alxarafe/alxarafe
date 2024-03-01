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
        Schema::create('c_forme_juridique', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('code')->unique('uk_c_forme_juridique');
            $table->integer('fk_pays');
            $table->string('libelle')->nullable();
            $table->tinyInteger('isvatexempted')->default(0);
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
        Schema::dropIfExists('c_forme_juridique');
    }
};
