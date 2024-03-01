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
        Schema::create('c_regions', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('code_region')->unique('uk_code_region');
            $table->integer('fk_pays')->index('idx_c_regions_fk_pays');
            $table->string('cheflieu', 50)->nullable();
            $table->integer('tncc')->nullable();
            $table->string('nom', 100)->nullable();
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
        Schema::dropIfExists('c_regions');
    }
};
