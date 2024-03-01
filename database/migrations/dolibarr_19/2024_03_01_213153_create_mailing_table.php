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
        Schema::create('mailing', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->smallInteger('statut')->nullable()->default(0);
            $table->string('titre', 128)->nullable();
            $table->integer('entity')->default(1);
            $table->string('sujet', 128)->nullable();
            $table->mediumText('body')->nullable();
            $table->string('bgcolor', 8)->nullable();
            $table->string('bgimage')->nullable();
            $table->smallInteger('evenunsubscribe')->nullable()->default(0);
            $table->string('cible', 60)->nullable();
            $table->integer('nbemail')->nullable();
            $table->string('email_from', 160)->nullable();
            $table->string('name_from', 128)->nullable();
            $table->string('email_replyto', 160)->nullable();
            $table->string('email_errorsto', 160)->nullable();
            $table->string('tag', 128)->nullable();
            $table->dateTime('date_creat')->nullable();
            $table->dateTime('date_valid')->nullable();
            $table->dateTime('date_appro')->nullable();
            $table->dateTime('date_envoi')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_user_creat')->nullable();
            $table->integer('fk_user_modif')->nullable();
            $table->integer('fk_user_valid')->nullable();
            $table->integer('fk_user_appro')->nullable();
            $table->string('extraparams')->nullable();
            $table->string('joined_file1')->nullable();
            $table->string('joined_file2')->nullable();
            $table->string('joined_file3')->nullable();
            $table->string('joined_file4')->nullable();
            $table->text('note_private')->nullable();
            $table->text('note_public')->nullable();

            $table->unique(['titre', 'entity'], 'uk_mailing');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mailing');
    }
};
