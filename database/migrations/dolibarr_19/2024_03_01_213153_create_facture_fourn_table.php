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
        Schema::create('facture_fourn', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('ref', 180);
            $table->string('ref_supplier', 180);
            $table->integer('entity')->default(1);
            $table->string('ref_ext')->nullable();
            $table->smallInteger('type')->default(0);
            $table->smallInteger('subtype')->nullable();
            $table->integer('fk_soc')->index('idx_facture_fourn_fk_soc');
            $table->dateTime('datec')->nullable();
            $table->date('datef')->nullable();
            $table->date('date_pointoftax')->nullable();
            $table->date('date_valid')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->dateTime('date_closing')->nullable();
            $table->string('libelle')->nullable();
            $table->smallInteger('paye')->default(0);
            $table->double('amount', 24, 8)->default(0);
            $table->double('remise', 24, 8)->nullable()->default(0);
            $table->string('close_code', 16)->nullable();
            $table->double('close_missing_amount', 24, 8)->nullable();
            $table->string('close_note', 128)->nullable();
            $table->tinyInteger('vat_reverse_charge')->nullable()->default(0);
            $table->double('tva', 24, 8)->nullable()->default(0);
            $table->double('total_tva', 24, 8)->nullable()->default(0);
            $table->double('localtax1', 24, 8)->nullable()->default(0);
            $table->double('localtax2', 24, 8)->nullable()->default(0);
            $table->double('revenuestamp', 24, 8)->nullable()->default(0);
            $table->double('total_ht', 24, 8)->nullable()->default(0);
            $table->double('total_ttc', 24, 8)->nullable()->default(0);
            $table->smallInteger('fk_statut')->default(0);
            $table->integer('fk_user_author')->nullable()->index('idx_facture_fourn_fk_user_author');
            $table->integer('fk_user_modif')->nullable();
            $table->integer('fk_user_valid')->nullable()->index('idx_facture_fourn_fk_user_valid');
            $table->integer('fk_user_closing')->nullable();
            $table->integer('fk_fac_rec_source')->nullable();
            $table->integer('fk_facture_source')->nullable();
            $table->integer('fk_projet')->nullable()->index('idx_facture_fourn_fk_projet');
            $table->integer('fk_account')->nullable();
            $table->integer('fk_cond_reglement')->nullable();
            $table->integer('fk_mode_reglement')->nullable();
            $table->date('date_lim_reglement')->nullable()->index('idx_facture_fourn_date_lim_reglement');
            $table->text('note_private')->nullable();
            $table->text('note_public')->nullable();
            $table->integer('fk_incoterms')->nullable();
            $table->string('location_incoterms')->nullable();
            $table->integer('fk_transport_mode')->nullable();
            $table->string('model_pdf')->nullable();
            $table->string('last_main_doc')->nullable();
            $table->string('import_key', 14)->nullable();
            $table->string('extraparams')->nullable();
            $table->integer('fk_multicurrency')->nullable();
            $table->string('multicurrency_code', 3)->nullable();
            $table->double('multicurrency_tx', 24, 8)->nullable()->default(1);
            $table->double('multicurrency_total_ht', 24, 8)->nullable()->default(0);
            $table->double('multicurrency_total_tva', 24, 8)->nullable()->default(0);
            $table->double('multicurrency_total_ttc', 24, 8)->nullable()->default(0);

            $table->unique(['ref', 'entity'], 'uk_facture_fourn_ref');
            $table->unique(['ref_supplier', 'fk_soc', 'entity'], 'uk_facture_fourn_ref_supplier');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facture_fourn');
    }
};
