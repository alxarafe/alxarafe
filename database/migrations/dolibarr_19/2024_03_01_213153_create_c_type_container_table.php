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
        Schema::create('c_type_container', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('code', 32);
            $table->integer('entity')->default(1);
            $table->string('label', 128);
            $table->string('module', 32)->nullable();
            $table->integer('position')->nullable()->default(0);
            $table->tinyInteger('active')->default(1);

            $table->unique(['code', 'entity'], 'uk_c_type_container_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_type_container');
    }
};
