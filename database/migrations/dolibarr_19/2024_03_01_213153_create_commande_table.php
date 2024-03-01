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
        Schema::create('commande', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('ref', 30);
            $table->integer('entity')->default(1);
            $table->string('ref_ext')->nullable();
            $table->string('ref_client')->nullable();
            $table->integer('fk_soc')->index('idx_commande_fk_soc');
            $table->integer('fk_projet')->nullable()->index('idx_commande_fk_projet');
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->dateTime('date_creation')->nullable();
            $table->dateTime('date_valid')->nullable();
            $table->dateTime('date_cloture')->nullable();
            $table->date('date_commande')->nullable();
            $table->integer('fk_user_author')->nullable()->index('idx_commande_fk_user_author');
            $table->integer('fk_user_modif')->nullable();
            $table->integer('fk_user_valid')->nullable()->index('idx_commande_fk_user_valid');
            $table->integer('fk_user_cloture')->nullable()->index('idx_commande_fk_user_cloture');
            $table->smallInteger('source')->nullable();
            $table->smallInteger('fk_statut')->nullable()->default(0);
            $table->double('amount_ht', 24, 8)->nullable()->default(0);
            $table->double('remise_percent')->nullable()->default(0);
            $table->double('remise_absolue')->nullable()->default(0);
            $table->double('remise')->nullable()->default(0);
            $table->double('total_tva', 24, 8)->nullable()->default(0);
            $table->double('localtax1', 24, 8)->nullable()->default(0);
            $table->double('localtax2', 24, 8)->nullable()->default(0);
            $table->double('revenuestamp', 24, 8)->nullable()->default(0);
            $table->double('total_ht', 24, 8)->nullable()->default(0);
            $table->double('total_ttc', 24, 8)->nullable()->default(0);
            $table->text('note_private')->nullable();
            $table->text('note_public')->nullable();
            $table->string('model_pdf')->nullable();
            $table->string('last_main_doc')->nullable();
            $table->string('module_source', 32)->nullable();
            $table->string('pos_source', 32)->nullable();
            $table->tinyInteger('facture')->nullable()->default(0);
            $table->integer('fk_account')->nullable()->index('idx_commande_fk_account');
            $table->string('fk_currency', 3)->nullable()->index('idx_commande_fk_currency');
            $table->integer('fk_cond_reglement')->nullable();
            $table->string('deposit_percent', 63)->nullable();
            $table->integer('fk_mode_reglement')->nullable();
            $table->dateTime('date_livraison')->nullable();
            $table->integer('fk_shipping_method')->nullable();
            $table->integer('fk_warehouse')->nullable();
            $table->integer('fk_availability')->nullable();
            $table->integer('fk_input_reason')->nullable();
            $table->integer('fk_delivery_address')->nullable();
            $table->integer('fk_incoterms')->nullable();
            $table->string('location_incoterms')->nullable();
            $table->string('import_key', 14)->nullable();
            $table->string('extraparams')->nullable();
            $table->integer('fk_multicurrency')->nullable();
            $table->string('multicurrency_code', 3)->nullable();
            $table->double('multicurrency_tx', 24, 8)->nullable()->default(1);
            $table->double('multicurrency_total_ht', 24, 8)->nullable()->default(0);
            $table->double('multicurrency_total_tva', 24, 8)->nullable()->default(0);
            $table->double('multicurrency_total_ttc', 24, 8)->nullable()->default(0);

            $table->unique(['ref', 'entity'], 'uk_commande_ref');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commande');
    }
};
