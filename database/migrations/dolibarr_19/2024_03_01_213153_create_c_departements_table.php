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
        Schema::create('c_departements', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('code_departement', 6);
            $table->integer('fk_region')->nullable()->index('idx_departements_fk_region');
            $table->string('cheflieu', 50)->nullable();
            $table->integer('tncc')->nullable();
            $table->string('ncc', 50)->nullable();
            $table->string('nom', 50)->nullable();
            $table->tinyInteger('active')->default(1);

            $table->unique(['code_departement', 'fk_region'], 'uk_departements');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_departements');
    }
};
