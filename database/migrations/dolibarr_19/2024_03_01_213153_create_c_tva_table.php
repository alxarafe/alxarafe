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
        Schema::create('c_tva', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(1);
            $table->integer('fk_pays');
            $table->string('code', 10)->nullable()->default('');
            $table->double('taux');
            $table->string('localtax1', 20)->default('0');
            $table->string('localtax1_type', 10)->default('0');
            $table->string('localtax2', 20)->default('0');
            $table->string('localtax2_type', 10)->default('0');
            $table->tinyInteger('use_default')->nullable()->default(0);
            $table->integer('recuperableonly')->default(0);
            $table->string('note', 128)->nullable();
            $table->tinyInteger('active')->default(1);
            $table->string('accountancy_code_sell', 32)->nullable();
            $table->string('accountancy_code_buy', 32)->nullable();

            $table->unique(['entity', 'fk_pays', 'code', 'taux', 'recuperableonly'], 'uk_c_tva_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_tva');
    }
};
