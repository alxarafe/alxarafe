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
        Schema::create('recruitment_recruitmentcandidature', function (Blueprint $table) {
            $table->integer('rowid', true)->index('idx_recruitment_recruitmentcandidature_rowid');
            $table->integer('entity')->default(1);
            $table->string('ref', 128)->default('(PROV)')->index('idx_recruitment_recruitmentcandidature_ref');
            $table->integer('fk_recruitmentjobposition')->nullable();
            $table->text('description')->nullable();
            $table->text('note_public')->nullable();
            $table->text('note_private')->nullable();
            $table->dateTime('date_creation');
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_user_creat')->index('llx_recruitment_recruitmentcandidature_fk_user_creat');
            $table->integer('fk_user_modif')->nullable();
            $table->integer('fk_user')->nullable();
            $table->string('import_key', 14)->nullable();
            $table->string('model_pdf')->nullable();
            $table->smallInteger('status')->index('idx_recruitment_recruitmentcandidature_status');
            $table->string('firstname', 128)->nullable();
            $table->string('lastname', 128)->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 64)->nullable();
            $table->date('date_birth')->nullable();
            $table->integer('remuneration_requested')->nullable();
            $table->integer('remuneration_proposed')->nullable();
            $table->string('email_msgid', 175)->nullable()->unique('uk_recruitmentcandidature_email_msgid');
            $table->dateTime('email_date')->nullable();
            $table->integer('fk_recruitment_origin')->nullable();

            $table->primary(['rowid']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recruitment_recruitmentcandidature');
    }
};
