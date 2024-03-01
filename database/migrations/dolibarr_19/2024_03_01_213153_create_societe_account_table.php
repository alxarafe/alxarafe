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
        Schema::create('societe_account', function (Blueprint $table) {
            $table->integer('rowid', true)->index('idx_societe_account_rowid');
            $table->integer('entity')->nullable()->default(1);
            $table->string('login', 128)->index('idx_societe_account_login');
            $table->string('pass_encoding', 24)->nullable();
            $table->string('pass_crypted', 128)->nullable();
            $table->string('pass_temp', 128)->nullable();
            $table->integer('fk_soc')->nullable()->index('idx_societe_account_fk_soc');
            $table->integer('fk_website')->nullable()->index('idx_societe_account_fk_website');
            $table->string('site', 128);
            $table->string('site_account', 128)->nullable();
            $table->string('key_account', 128)->nullable();
            $table->text('note_private')->nullable();
            $table->dateTime('date_last_login')->nullable();
            $table->dateTime('date_previous_login')->nullable();
            $table->dateTime('date_creation');
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_user_creat');
            $table->integer('fk_user_modif')->nullable();
            $table->string('import_key', 14)->nullable();
            $table->integer('status')->nullable()->index('idx_societe_account_status');

            $table->primary(['rowid']);
            $table->unique(['entity', 'fk_soc', 'key_account', 'site', 'fk_website'], 'uk_societe_account_key_account_soc');
            $table->unique(['entity', 'fk_soc', 'login', 'site', 'fk_website'], 'uk_societe_account_login_website_soc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('societe_account');
    }
};
