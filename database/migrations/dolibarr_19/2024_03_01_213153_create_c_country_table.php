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
        Schema::create('c_country', function (Blueprint $table) {
            $table->integer('rowid')->primary();
            $table->string('code', 2)->unique('idx_c_country_code');
            $table->string('code_iso', 3)->nullable()->unique('idx_c_country_code_iso');
            $table->string('numeric_code', 3)->nullable();
            $table->string('label', 128)->unique('idx_c_country_label');
            $table->tinyInteger('eec')->default(0);
            $table->tinyInteger('active')->default(1);
            $table->tinyInteger('favorite')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_country');
    }
};
