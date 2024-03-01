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
        Schema::create('paiementfourn', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('ref', 30)->nullable();
            $table->integer('entity')->nullable()->default(1);
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->dateTime('datec')->nullable();
            $table->dateTime('datep')->nullable();
            $table->double('amount', 24, 8)->nullable()->default(0);
            $table->double('multicurrency_amount', 24, 8)->nullable()->default(0);
            $table->integer('fk_user_author')->nullable();
            $table->integer('fk_user_modif')->nullable();
            $table->integer('fk_paiement');
            $table->string('num_paiement', 50)->nullable();
            $table->text('note')->nullable();
            $table->integer('fk_bank');
            $table->smallInteger('statut')->default(0);
            $table->string('model_pdf')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paiementfourn');
    }
};
