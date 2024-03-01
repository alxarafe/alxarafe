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
        Schema::create('bank_account', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->dateTime('datec')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->string('ref', 12);
            $table->string('label', 30);
            $table->integer('entity')->default(1);
            $table->integer('fk_user_author')->nullable();
            $table->integer('fk_user_modif')->nullable();
            $table->string('bank', 60)->nullable();
            $table->string('code_banque', 128)->nullable();
            $table->string('code_guichet', 6)->nullable();
            $table->string('number')->nullable();
            $table->string('cle_rib', 5)->nullable();
            $table->string('bic', 11)->nullable();
            $table->string('bic_intermediate', 11)->nullable();
            $table->string('iban_prefix', 34)->nullable();
            $table->string('country_iban', 2)->nullable();
            $table->string('cle_iban', 2)->nullable();
            $table->string('domiciliation')->nullable();
            $table->smallInteger('pti_in_ctti')->nullable()->default(0);
            $table->integer('state_id')->nullable();
            $table->integer('fk_pays');
            $table->string('proprio', 60)->nullable();
            $table->string('owner_address')->nullable();
            $table->string('owner_zip', 25)->nullable();
            $table->string('owner_town', 50)->nullable();
            $table->integer('owner_country_id')->nullable();
            $table->smallInteger('courant')->default(0);
            $table->smallInteger('clos')->default(0);
            $table->smallInteger('rappro')->nullable()->default(1);
            $table->string('url', 128)->nullable();
            $table->string('account_number', 32)->nullable();
            $table->integer('fk_accountancy_journal')->nullable()->index('idx_fk_accountancy_journal');
            $table->string('currency_code', 3);
            $table->integer('min_allowed')->nullable()->default(0);
            $table->integer('min_desired')->nullable()->default(0);
            $table->text('comment')->nullable();
            $table->text('note_public')->nullable();
            $table->string('model_pdf')->nullable();
            $table->string('import_key', 14)->nullable();
            $table->string('extraparams')->nullable();
            $table->string('ics', 32)->nullable();
            $table->string('ics_transfer', 32)->nullable();

            $table->unique(['label', 'entity'], 'uk_bank_account_label');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_account');
    }
};
