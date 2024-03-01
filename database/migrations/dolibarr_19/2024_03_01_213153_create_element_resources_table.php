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
        Schema::create('element_resources', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('element_id')->nullable()->index('idx_element_element_element_id');
            $table->string('element_type', 64)->nullable();
            $table->integer('resource_id')->nullable();
            $table->string('resource_type', 64)->nullable();
            $table->integer('busy')->nullable();
            $table->integer('mandatory')->nullable();
            $table->double('duree')->nullable();
            $table->integer('fk_user_create')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();

            $table->unique(['resource_id', 'resource_type', 'element_id', 'element_type'], 'idx_element_resources_idx1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('element_resources');
    }
};
