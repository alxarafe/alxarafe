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
        Schema::create('contrat', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('ref')->nullable();
            $table->string('ref_customer')->nullable();
            $table->string('ref_supplier')->nullable();
            $table->string('ref_ext')->nullable();
            $table->integer('entity')->default(1);
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->dateTime('datec')->nullable();
            $table->dateTime('date_contrat')->nullable();
            $table->smallInteger('statut')->nullable()->default(0);
            $table->dateTime('fin_validite')->nullable();
            $table->dateTime('date_cloture')->nullable();
            $table->integer('fk_soc')->index('idx_contrat_fk_soc');
            $table->integer('fk_projet')->nullable();
            $table->integer('fk_commercial_signature')->nullable();
            $table->integer('fk_commercial_suivi')->nullable();
            $table->integer('fk_user_author')->default(0)->index('idx_contrat_fk_user_author');
            $table->integer('fk_user_modif')->nullable();
            $table->integer('fk_user_cloture')->nullable();
            $table->text('note_private')->nullable();
            $table->text('note_public')->nullable();
            $table->string('model_pdf')->nullable();
            $table->string('last_main_doc')->nullable();
            $table->string('import_key', 14)->nullable();
            $table->string('extraparams')->nullable();

            $table->unique(['ref', 'entity'], 'uk_contrat_ref');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contrat');
    }
};
