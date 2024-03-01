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
        Schema::create('mailing_cibles', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_mailing');
            $table->integer('fk_contact');
            $table->string('lastname', 160)->nullable();
            $table->string('firstname', 160)->nullable();
            $table->string('email', 160)->index('idx_mailing_cibles_email');
            $table->string('other')->nullable();
            $table->string('tag', 64)->nullable()->index('idx_mailing_cibles_tag');
            $table->smallInteger('statut')->default(0);
            $table->string('source_url')->nullable();
            $table->integer('source_id')->nullable();
            $table->string('source_type', 32)->nullable();
            $table->dateTime('date_envoi')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->string('error_text')->nullable();

            $table->unique(['fk_mailing', 'email'], 'uk_mailing_cibles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mailing_cibles');
    }
};
