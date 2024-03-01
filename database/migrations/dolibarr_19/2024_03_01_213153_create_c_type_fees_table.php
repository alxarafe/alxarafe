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
        Schema::create('c_type_fees', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('code', 12)->unique('uk_c_type_fees');
            $table->string('label', 128)->nullable();
            $table->integer('type')->nullable()->default(0);
            $table->string('accountancy_code', 32)->nullable();
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
        Schema::dropIfExists('c_type_fees');
    }
};
