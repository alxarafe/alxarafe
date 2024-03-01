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
        Schema::create('c_units', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('code', 3)->nullable()->unique('uk_c_units_code');
            $table->smallInteger('sortorder')->nullable();
            $table->integer('scale')->nullable();
            $table->string('label', 128)->nullable();
            $table->string('short_label', 5)->nullable();
            $table->string('unit_type', 10)->nullable();
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
        Schema::dropIfExists('c_units');
    }
};
