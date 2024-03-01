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
        Schema::create('societe_rib', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('type', 32)->default('ban');
            $table->string('label', 200)->nullable();
            $table->integer('fk_soc')->index('llx_societe_rib_fk_societe');
            $table->dateTime('datec')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->string('bank')->nullable();
            $table->string('code_banque', 128)->nullable();
            $table->string('code_guichet', 6)->nullable();
            $table->string('number')->nullable();
            $table->string('cle_rib', 5)->nullable();
            $table->string('bic', 20)->nullable();
            $table->string('bic_intermediate', 11)->nullable();
            $table->string('iban_prefix', 34)->nullable();
            $table->string('domiciliation')->nullable();
            $table->string('proprio', 60)->nullable();
            $table->string('owner_address')->nullable();
            $table->smallInteger('default_rib')->default(0);
            $table->integer('state_id')->nullable();
            $table->integer('fk_country')->nullable();
            $table->string('currency_code', 3)->nullable();
            $table->string('model_pdf')->nullable();
            $table->string('last_main_doc')->nullable();
            $table->string('rum', 32)->nullable();
            $table->date('date_rum')->nullable();
            $table->string('frstrecur', 16)->nullable()->default('FRST');
            $table->string('last_four', 4)->nullable();
            $table->string('card_type')->nullable();
            $table->string('cvn')->nullable();
            $table->integer('exp_date_month')->nullable();
            $table->integer('exp_date_year')->nullable();
            $table->string('country_code', 10)->nullable();
            $table->integer('approved')->nullable()->default(0);
            $table->string('email')->nullable();
            $table->date('ending_date')->nullable();
            $table->double('max_total_amount_of_all_payments', 24, 8)->nullable();
            $table->string('preapproval_key')->nullable();
            $table->date('starting_date')->nullable();
            $table->double('total_amount_of_all_payments', 24, 8)->nullable();
            $table->string('stripe_card_ref', 128)->nullable();
            $table->string('stripe_account', 128)->nullable();
            $table->string('ext_payment_site', 128)->nullable();
            $table->string('extraparams')->nullable();
            $table->dateTime('date_signature')->nullable();
            $table->string('online_sign_ip', 48)->nullable();
            $table->string('online_sign_name', 64)->nullable();
            $table->string('comment')->nullable();
            $table->string('ipaddress', 68)->nullable();
            $table->integer('status')->default(1);
            $table->string('import_key', 14)->nullable();

            $table->unique(['label', 'fk_soc'], 'uk_societe_rib');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('societe_rib');
    }
};
