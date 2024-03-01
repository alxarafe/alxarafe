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
        Schema::create('eventorganization_conferenceorboothattendee', function (Blueprint $table) {
            $table->integer('rowid', true)->index('idx_eventorganization_conferenceorboothattendee_rowid');
            $table->string('ref', 128)->index('idx_eventorganization_conferenceorboothattendee_ref');
            $table->integer('fk_soc')->nullable()->index('idx_eventorganization_conferenceorboothattendee_fk_soc');
            $table->integer('fk_actioncomm')->nullable()->index('idx_eventorganization_conferenceorboothattendee_fk_actioncomm');
            $table->integer('fk_project')->index('idx_eventorganization_conferenceorboothattendee_fk_project');
            $table->integer('fk_invoice')->nullable();
            $table->string('email', 128)->nullable()->index('idx_eventorganization_conferenceorboothattendee_email');
            $table->string('email_company', 128)->nullable();
            $table->string('firstname', 100)->nullable();
            $table->string('lastname', 100)->nullable();
            $table->dateTime('date_subscription')->nullable();
            $table->double('amount')->nullable();
            $table->text('note_public')->nullable();
            $table->text('note_private')->nullable();
            $table->dateTime('date_creation');
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_user_creat')->nullable();
            $table->integer('fk_user_modif')->nullable();
            $table->string('last_main_doc')->nullable();
            $table->string('ip', 250)->nullable();
            $table->string('import_key', 14)->nullable();
            $table->string('model_pdf')->nullable();
            $table->smallInteger('status')->index('idx_eventorganization_conferenceorboothattendee_status');

            $table->primary(['rowid']);
            $table->unique(['fk_project', 'email', 'fk_actioncomm'], 'uk_eventorganization_conferenceorboothattendee');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eventorganization_conferenceorboothattendee');
    }
};
