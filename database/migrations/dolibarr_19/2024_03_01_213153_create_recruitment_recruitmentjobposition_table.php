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
        Schema::create('recruitment_recruitmentjobposition', function (Blueprint $table) {
            $table->integer('rowid', true)->index('idx_recruitment_recruitmentjobposition_rowid');
            $table->string('ref', 128)->default('(PROV)')->index('idx_recruitment_recruitmentjobposition_ref');
            $table->integer('entity')->default(1);
            $table->string('label');
            $table->integer('qty')->default(1);
            $table->integer('fk_soc')->nullable()->index('idx_recruitment_recruitmentjobposition_fk_soc');
            $table->integer('fk_project')->nullable()->index('idx_recruitment_recruitmentjobposition_fk_project');
            $table->integer('fk_user_recruiter')->nullable()->index('llx_recruitment_recruitmentjobposition_fk_user_recruiter');
            $table->string('email_recruiter')->nullable();
            $table->integer('fk_user_supervisor')->nullable()->index('llx_recruitment_recruitmentjobposition_fk_user_supervisor');
            $table->integer('fk_establishment')->nullable()->index('llx_recruitment_recruitmentjobposition_fk_establishment');
            $table->date('date_planned')->nullable();
            $table->string('remuneration_suggested')->nullable();
            $table->text('description')->nullable();
            $table->text('note_public')->nullable();
            $table->text('note_private')->nullable();
            $table->dateTime('date_creation');
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_user_creat')->index('llx_recruitment_recruitmentjobposition_fk_user_creat');
            $table->integer('fk_user_modif')->nullable();
            $table->string('last_main_doc')->nullable();
            $table->string('import_key', 14)->nullable();
            $table->string('model_pdf')->nullable();
            $table->smallInteger('status')->index('idx_recruitment_recruitmentjobposition_status');

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
        Schema::dropIfExists('recruitment_recruitmentjobposition');
    }
};
