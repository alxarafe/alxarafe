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
        Schema::create('rights_def', function (Blueprint $table) {
            $table->integer('id');
            $table->string('libelle')->nullable();
            $table->string('module', 64)->nullable();
            $table->integer('module_position')->default(0);
            $table->integer('family_position')->default(0);
            $table->integer('entity')->default(1);
            $table->string('perms', 50)->nullable();
            $table->string('subperms', 50)->nullable();
            $table->string('type', 1)->nullable();
            $table->tinyInteger('bydefault')->nullable()->default(0);

            $table->primary(['id', 'entity']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rights_def');
    }
};
