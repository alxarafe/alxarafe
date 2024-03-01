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
        Schema::create('export_model', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->nullable()->default(0);
            $table->integer('fk_user')->default(0);
            $table->string('label', 50);
            $table->string('type', 64);
            $table->text('field');
            $table->text('filter')->nullable();

            $table->unique(['label', 'type'], 'uk_export_model');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('export_model');
    }
};
