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
        Schema::create('prelevement_lignes', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_prelevement_bons')->nullable()->index('idx_prelevement_lignes_fk_prelevement_bons');
            $table->integer('fk_soc');
            $table->integer('fk_user')->nullable();
            $table->smallInteger('statut')->nullable()->default(0);
            $table->string('client_nom')->nullable();
            $table->double('amount', 24, 8)->nullable()->default(0);
            $table->string('code_banque', 128)->nullable();
            $table->string('code_guichet', 6)->nullable();
            $table->string('number')->nullable();
            $table->string('cle_rib', 5)->nullable();
            $table->text('note')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prelevement_lignes');
    }
};
