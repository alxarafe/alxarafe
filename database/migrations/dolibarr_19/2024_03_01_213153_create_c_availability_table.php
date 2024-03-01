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
        Schema::create('c_availability', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('code', 30)->unique('uk_c_availability');
            $table->string('label', 128);
            $table->string('type_duration', 1)->nullable();
            $table->double('qty')->nullable();
            $table->tinyInteger('active')->default(1);
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
        Schema::dropIfExists('c_availability');
    }
};
