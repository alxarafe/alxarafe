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
        Schema::create('user', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(1);
            $table->string('ref_employee', 50)->nullable();
            $table->string('ref_ext', 50)->nullable();
            $table->smallInteger('admin')->nullable()->default(0);
            $table->tinyInteger('employee')->nullable()->default(1);
            $table->integer('fk_establishment')->nullable()->default(0);
            $table->dateTime('datec')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_user_creat')->nullable();
            $table->integer('fk_user_modif')->nullable();
            $table->string('login', 50);
            $table->string('pass_encoding', 24)->nullable();
            $table->string('pass', 128)->nullable();
            $table->string('pass_crypted', 128)->nullable();
            $table->string('pass_temp', 128)->nullable();
            $table->string('api_key', 128)->nullable()->unique('uk_user_api_key');
            $table->string('gender', 10)->nullable();
            $table->string('civility', 6)->nullable();
            $table->string('lastname', 50)->nullable();
            $table->string('firstname', 50)->nullable();
            $table->string('address')->nullable();
            $table->string('zip', 25)->nullable();
            $table->string('town', 50)->nullable();
            $table->integer('fk_state')->nullable()->default(0);
            $table->integer('fk_country')->nullable()->default(0);
            $table->date('birth')->nullable();
            $table->string('birth_place', 64)->nullable();
            $table->string('job', 128)->nullable();
            $table->string('office_phone', 20)->nullable();
            $table->string('office_fax', 20)->nullable();
            $table->string('user_mobile', 20)->nullable();
            $table->string('personal_mobile', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('personal_email')->nullable();
            $table->string('email_oauth2')->nullable();
            $table->text('signature')->nullable();
            $table->text('socialnetworks')->nullable();
            $table->integer('fk_soc')->nullable()->index('idx_user_fk_societe');
            $table->integer('fk_socpeople')->nullable()->unique('uk_user_fk_socpeople');
            $table->integer('fk_member')->nullable()->unique('uk_user_fk_member');
            $table->integer('fk_user')->nullable();
            $table->integer('fk_user_expense_validator')->nullable();
            $table->integer('fk_user_holiday_validator')->nullable();
            $table->string('idpers1', 128)->nullable();
            $table->string('idpers2', 128)->nullable();
            $table->string('idpers3', 128)->nullable();
            $table->text('note_public')->nullable();
            $table->text('note_private')->nullable();
            $table->string('model_pdf')->nullable();
            $table->string('last_main_doc')->nullable();
            $table->dateTime('datelastlogin')->nullable();
            $table->dateTime('datepreviouslogin')->nullable();
            $table->dateTime('datelastpassvalidation')->nullable();
            $table->dateTime('datestartvalidity')->nullable();
            $table->dateTime('dateendvalidity')->nullable();
            $table->dateTime('flagdelsessionsbefore')->nullable();
            $table->string('iplastlogin', 250)->nullable();
            $table->string('ippreviouslogin', 250)->nullable();
            $table->integer('egroupware_id')->nullable();
            $table->string('ldap_sid')->nullable();
            $table->string('openid')->nullable();
            $table->tinyInteger('statut')->nullable()->default(1);
            $table->string('photo')->nullable();
            $table->string('lang', 6)->nullable();
            $table->string('color', 6)->nullable();
            $table->string('barcode')->nullable();
            $table->integer('fk_barcode_type')->nullable()->default(0);
            $table->string('accountancy_code', 32)->nullable();
            $table->integer('nb_holiday')->nullable()->default(0);
            $table->double('thm', 24, 8)->nullable();
            $table->double('tjm', 24, 8)->nullable();
            $table->double('salary', 24, 8)->nullable();
            $table->double('salaryextra', 24, 8)->nullable();
            $table->date('dateemployment')->nullable();
            $table->date('dateemploymentend')->nullable();
            $table->double('weeklyhours', 16, 8)->nullable();
            $table->string('import_key', 14)->nullable();
            $table->integer('default_range')->nullable();
            $table->integer('default_c_exp_tax_cat')->nullable();
            $table->string('national_registration_number', 50)->nullable();
            $table->integer('fk_warehouse')->nullable();

            $table->unique(['login', 'entity'], 'uk_user_login');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
};
