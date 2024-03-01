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
        Schema::create('element_element', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_source');
            $table->string('sourcetype', 32);
            $table->integer('fk_target')->index('idx_element_element_fk_target');
            $table->string('targettype', 32);

            $table->unique(['fk_source', 'sourcetype', 'fk_target', 'targettype'], 'idx_element_element_idx1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('element_element');
    }
};
