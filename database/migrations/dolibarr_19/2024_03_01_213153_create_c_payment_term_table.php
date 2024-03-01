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
        Schema::create('c_payment_term', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(1);
            $table->string('code', 16)->nullable();
            $table->smallInteger('sortorder')->nullable();
            $table->tinyInteger('active')->nullable()->default(1);
            $table->string('libelle')->nullable();
            $table->text('libelle_facture')->nullable();
            $table->tinyInteger('type_cdr')->nullable();
            $table->smallInteger('nbjour')->nullable();
            $table->smallInteger('decalage')->nullable();
            $table->string('deposit_percent', 63)->nullable();
            $table->string('module', 32)->nullable();
            $table->integer('position')->default(0);

            $table->unique(['entity', 'code'], 'uk_c_payment_term_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_payment_term');
    }
};
