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
        Schema::create('const', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('name', 180);
            $table->integer('entity')->default(1);
            $table->text('value');
            $table->string('type', 64)->nullable()->default('string');
            $table->tinyInteger('visible')->default(1);
            $table->text('note')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();

            $table->unique(['name', 'entity'], 'uk_const');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('const');
    }
};
