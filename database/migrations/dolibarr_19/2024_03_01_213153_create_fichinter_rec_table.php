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
        Schema::create('fichinter_rec', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('titre', 50);
            $table->integer('entity')->default(1);
            $table->integer('fk_soc')->nullable()->index('idx_fichinter_rec_fk_soc');
            $table->dateTime('datec')->nullable();
            $table->integer('fk_contrat')->nullable()->default(0);
            $table->integer('fk_user_author')->nullable()->index('idx_fichinter_rec_fk_user_author');
            $table->integer('fk_projet')->nullable()->index('idx_fichinter_rec_fk_projet');
            $table->double('duree')->nullable();
            $table->text('description')->nullable();
            $table->string('modelpdf', 50)->nullable();
            $table->text('note_private')->nullable();
            $table->text('note_public')->nullable();
            $table->integer('frequency')->nullable();
            $table->string('unit_frequency', 2)->nullable()->default('m');
            $table->dateTime('date_when')->nullable();
            $table->dateTime('date_last_gen')->nullable();
            $table->integer('nb_gen_done')->nullable();
            $table->integer('nb_gen_max')->nullable();
            $table->integer('auto_validate')->nullable();

            $table->unique(['titre', 'entity'], 'idx_fichinter_rec_uk_titre');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fichinter_rec');
    }
};
