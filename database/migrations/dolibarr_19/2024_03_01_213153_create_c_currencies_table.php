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
        Schema::create('c_currencies', function (Blueprint $table) {
            $table->string('code_iso', 3)->primary();
            $table->string('label', 128);
            $table->string('unicode', 32)->nullable();
            $table->tinyInteger('active')->default(1);

            $table->unique(['code_iso'], 'uk_c_currencies_code_iso');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_currencies');
    }
};
