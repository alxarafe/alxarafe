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
        Schema::create('c_barcode_type', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('code', 16);
            $table->integer('entity')->default(1);
            $table->string('libelle', 128);
            $table->string('coder', 16);
            $table->string('example', 16);

            $table->unique(['code', 'entity'], 'uk_c_barcode_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_barcode_type');
    }
};
