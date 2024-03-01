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
        Schema::create('c_incoterms', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('code', 3)->unique('uk_c_incoterms');
            $table->string('label', 100)->nullable();
            $table->string('libelle');
            $table->tinyInteger('active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_incoterms');
    }
};
