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
        Schema::create('import_model', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(0);
            $table->integer('fk_user')->default(0);
            $table->string('label', 50);
            $table->string('type', 64);
            $table->text('field');

            $table->unique(['label', 'type'], 'uk_import_model');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('import_model');
    }
};
