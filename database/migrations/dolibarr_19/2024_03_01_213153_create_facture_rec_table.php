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
        Schema::create('facture_rec', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('titre', 200);
            $table->integer('entity')->default(1);
            $table->smallInteger('subtype')->nullable();
            $table->integer('fk_soc')->index('idx_facture_rec_fk_soc');
            $table->dateTime('datec')->nullable()->index('idx_facture_rec_datec');
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('suspended')->nullable()->default(0);
            $table->double('amount', 24, 8)->default(0);
            $table->double('remise')->nullable()->default(0);
            $table->double('remise_percent')->nullable()->default(0);
            $table->double('remise_absolue')->nullable()->default(0);
            $table->string('vat_src_code', 10)->nullable()->default('');
            $table->double('total_tva', 24, 8)->nullable()->default(0);
            $table->double('localtax1', 24, 8)->nullable()->default(0);
            $table->double('localtax2', 24, 8)->nullable()->default(0);
            $table->double('revenuestamp', 24, 8)->nullable()->default(0);
            $table->double('total_ht', 24, 8)->nullable()->default(0);
            $table->double('total_ttc', 24, 8)->nullable()->default(0);
            $table->integer('fk_user_author')->nullable()->index('idx_facture_rec_fk_user_author');
            $table->integer('fk_user_modif')->nullable();
            $table->integer('fk_projet')->nullable()->index('idx_facture_rec_fk_projet');
            $table->integer('fk_cond_reglement')->default(1);
            $table->integer('fk_mode_reglement')->nullable()->default(0);
            $table->date('date_lim_reglement')->nullable();
            $table->integer('fk_account')->nullable();
            $table->text('note_private')->nullable();
            $table->text('note_public')->nullable();
            $table->string('modelpdf')->nullable();
            $table->integer('fk_multicurrency')->nullable();
            $table->string('multicurrency_code', 3)->nullable();
            $table->double('multicurrency_tx', 24, 8)->nullable()->default(1);
            $table->double('multicurrency_total_ht', 24, 8)->nullable()->default(0);
            $table->double('multicurrency_total_tva', 24, 8)->nullable()->default(0);
            $table->double('multicurrency_total_ttc', 24, 8)->nullable()->default(0);
            $table->integer('usenewprice')->nullable()->default(0);
            $table->integer('frequency')->nullable();
            $table->string('unit_frequency', 2)->nullable()->default('m');
            $table->dateTime('date_when')->nullable();
            $table->dateTime('date_last_gen')->nullable();
            $table->integer('nb_gen_done')->nullable();
            $table->integer('nb_gen_max')->nullable();
            $table->integer('auto_validate')->nullable()->default(0);
            $table->integer('generate_pdf')->nullable()->default(1);

            $table->unique(['titre', 'entity'], 'idx_facture_rec_uk_titre');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facture_rec');
    }
};
