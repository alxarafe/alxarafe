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
        Schema::create('expensereport', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('ref', 50);
            $table->integer('entity')->default(1);
            $table->integer('ref_number_int')->nullable();
            $table->integer('ref_ext')->nullable();
            $table->double('total_ht', 24, 8)->nullable()->default(0);
            $table->double('total_tva', 24, 8)->nullable()->default(0);
            $table->double('localtax1', 24, 8)->nullable()->default(0);
            $table->double('localtax2', 24, 8)->nullable()->default(0);
            $table->double('total_ttc', 24, 8)->nullable()->default(0);
            $table->date('date_debut')->index('idx_expensereport_date_debut');
            $table->date('date_fin')->index('idx_expensereport_date_fin');
            $table->dateTime('date_create');
            $table->dateTime('date_valid')->nullable();
            $table->dateTime('date_approve')->nullable();
            $table->dateTime('date_refuse')->nullable();
            $table->dateTime('date_cancel')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_user_author')->index('idx_expensereport_fk_user_author');
            $table->integer('fk_user_creat')->nullable();
            $table->integer('fk_user_modif')->nullable();
            $table->integer('fk_user_valid')->nullable()->index('idx_expensereport_fk_user_valid');
            $table->integer('fk_user_validator')->nullable();
            $table->integer('fk_user_approve')->nullable()->index('idx_expensereport_fk_user_approve');
            $table->integer('fk_user_refuse')->nullable()->index('idx_expensereport_fk_refuse');
            $table->integer('fk_user_cancel')->nullable();
            $table->integer('fk_statut')->index('idx_expensereport_fk_statut');
            $table->integer('fk_c_paiement')->nullable();
            $table->smallInteger('paid')->default(0);
            $table->text('note_public')->nullable();
            $table->text('note_private')->nullable();
            $table->string('detail_refuse')->nullable();
            $table->string('detail_cancel')->nullable();
            $table->integer('integration_compta')->nullable();
            $table->integer('fk_bank_account')->nullable();
            $table->string('model_pdf', 50)->nullable();
            $table->string('last_main_doc')->nullable();
            $table->integer('fk_multicurrency')->nullable();
            $table->string('multicurrency_code', 3)->nullable();
            $table->double('multicurrency_tx', 24, 8)->nullable()->default(1);
            $table->double('multicurrency_total_ht', 24, 8)->nullable()->default(0);
            $table->double('multicurrency_total_tva', 24, 8)->nullable()->default(0);
            $table->double('multicurrency_total_ttc', 24, 8)->nullable()->default(0);
            $table->string('import_key', 14)->nullable();
            $table->string('extraparams')->nullable();

            $table->unique(['ref', 'entity'], 'idx_expensereport_uk_ref');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expensereport');
    }
};
