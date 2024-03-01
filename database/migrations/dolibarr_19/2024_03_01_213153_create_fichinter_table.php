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
        Schema::create('fichinter', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_soc')->index('idx_fichinter_fk_soc');
            $table->integer('fk_projet')->nullable()->default(0);
            $table->integer('fk_contrat')->nullable()->default(0);
            $table->string('ref', 30);
            $table->string('ref_ext')->nullable();
            $table->string('ref_client')->nullable();
            $table->integer('entity')->default(1);
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->dateTime('datec')->nullable();
            $table->dateTime('date_valid')->nullable();
            $table->date('datei')->nullable();
            $table->integer('fk_user_author')->nullable();
            $table->integer('fk_user_modif')->nullable();
            $table->integer('fk_user_valid')->nullable();
            $table->smallInteger('fk_statut')->nullable()->default(0);
            $table->date('dateo')->nullable();
            $table->date('datee')->nullable();
            $table->date('datet')->nullable();
            $table->double('duree')->nullable();
            $table->text('description')->nullable();
            $table->text('note_private')->nullable();
            $table->text('note_public')->nullable();
            $table->string('model_pdf')->nullable();
            $table->string('last_main_doc')->nullable();
            $table->string('import_key', 14)->nullable();
            $table->string('extraparams')->nullable();

            $table->unique(['ref', 'entity'], 'uk_fichinter_ref');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fichinter');
    }
};
