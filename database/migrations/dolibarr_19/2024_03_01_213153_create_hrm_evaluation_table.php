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
        Schema::create('hrm_evaluation', function (Blueprint $table) {
            $table->integer('rowid', true)->index('idx_hrm_evaluation_rowid');
            $table->string('ref', 128)->default('(PROV)')->index('idx_hrm_evaluation_ref');
            $table->string('label')->nullable();
            $table->text('description')->nullable();
            $table->text('note_public')->nullable();
            $table->text('note_private')->nullable();
            $table->string('model_pdf')->nullable();
            $table->string('last_main_doc')->nullable();
            $table->dateTime('date_creation');
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_user_creat')->index('llx_hrm_evaluation_fk_user_creat');
            $table->integer('fk_user_modif')->nullable();
            $table->string('import_key', 14)->nullable();
            $table->smallInteger('status')->index('idx_hrm_evaluation_status');
            $table->date('date_eval')->nullable();
            $table->integer('fk_user');
            $table->integer('fk_job');

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
        Schema::dropIfExists('hrm_evaluation');
    }
};
