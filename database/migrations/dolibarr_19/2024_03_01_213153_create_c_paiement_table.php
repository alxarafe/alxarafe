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
        Schema::create('c_paiement', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('entity')->default(1);
            $table->string('code', 6);
            $table->string('libelle', 128)->nullable();
            $table->smallInteger('type')->nullable();
            $table->tinyInteger('active')->default(1);
            $table->string('accountancy_code', 32)->nullable();
            $table->string('module', 32)->nullable();
            $table->integer('position')->default(0);

            $table->unique(['entity', 'code'], 'uk_c_paiement_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_paiement');
    }
};
