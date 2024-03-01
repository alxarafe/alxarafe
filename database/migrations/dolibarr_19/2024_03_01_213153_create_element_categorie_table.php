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
        Schema::create('element_categorie', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_categorie')->index('fk_element_categorie_fk_categorie');
            $table->integer('fk_element');
            $table->string('import_key', 14)->nullable();

            $table->unique(['fk_element', 'fk_categorie'], 'idx_element_categorie_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('element_categorie');
    }
};
