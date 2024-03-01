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
        Schema::create('c_ecotaxe', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('code', 64)->unique('uk_c_ecotaxe');
            $table->string('label')->nullable();
            $table->double('price', 24, 8)->nullable();
            $table->string('organization')->nullable();
            $table->integer('fk_pays');
            $table->tinyInteger('active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_ecotaxe');
    }
};
