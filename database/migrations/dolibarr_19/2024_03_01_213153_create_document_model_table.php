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
        Schema::create('document_model', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('nom', 50)->nullable();
            $table->integer('entity')->default(1);
            $table->string('type', 64);
            $table->string('libelle')->nullable();
            $table->text('description')->nullable();

            $table->unique(['nom', 'type', 'entity'], 'uk_document_model');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_model');
    }
};
