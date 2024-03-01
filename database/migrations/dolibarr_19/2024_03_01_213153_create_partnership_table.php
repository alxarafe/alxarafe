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
        Schema::create('partnership', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(1)->index('idx_partnership_entity');
            $table->string('ref', 128)->default('(PROV)');
            $table->smallInteger('status')->default(0);
            $table->integer('fk_type')->default(0);
            $table->integer('fk_soc')->nullable();
            $table->integer('fk_member')->nullable();
            $table->string('email_partnership', 64)->nullable();
            $table->date('date_partnership_start');
            $table->date('date_partnership_end')->nullable();
            $table->text('reason_decline_or_cancel')->nullable();
            $table->dateTime('date_creation');
            $table->integer('fk_user_creat')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_user_modif')->nullable();
            $table->text('note_private')->nullable();
            $table->text('note_public')->nullable();
            $table->string('last_main_doc')->nullable();
            $table->string('url_to_check')->nullable();
            $table->integer('count_last_url_check_error')->nullable()->default(0);
            $table->dateTime('last_check_backlink')->nullable();
            $table->string('ip', 250)->nullable();
            $table->string('import_key', 14)->nullable();
            $table->string('model_pdf')->nullable();

            $table->unique(['fk_type', 'fk_member', 'date_partnership_start'], 'uk_fk_type_fk_member');
            $table->unique(['fk_type', 'fk_soc', 'date_partnership_start'], 'uk_fk_type_fk_soc');
            $table->unique(['ref', 'entity'], 'uk_partnership_ref');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partnership');
    }
};
