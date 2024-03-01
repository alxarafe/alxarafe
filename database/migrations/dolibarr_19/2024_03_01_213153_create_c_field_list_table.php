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
        Schema::create('c_field_list', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->string('element', 64);
            $table->integer('entity')->default(1);
            $table->string('name', 32);
            $table->string('alias', 32);
            $table->string('title', 32);
            $table->string('align', 6)->nullable()->default('left');
            $table->tinyInteger('sort')->default(1);
            $table->tinyInteger('search')->default(0);
            $table->tinyInteger('visible')->default(1);
            $table->string('enabled')->nullable()->default('1');
            $table->integer('rang')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_field_list');
    }
};
