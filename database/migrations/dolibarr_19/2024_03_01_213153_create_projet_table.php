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
        Schema::create('projet', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_project')->nullable();
            $table->integer('fk_soc')->nullable()->index('idx_projet_fk_soc');
            $table->dateTime('datec')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->date('dateo')->nullable();
            $table->date('datee')->nullable();
            $table->string('ref', 50)->nullable()->index('idx_projet_ref');
            $table->integer('entity')->default(1);
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('fk_user_creat');
            $table->integer('fk_user_modif')->nullable();
            $table->integer('public')->nullable();
            $table->integer('fk_statut')->default(0)->index('idx_projet_fk_statut');
            $table->integer('fk_opp_status')->nullable()->index('idx_projet_fk_opp_status');
            $table->double('opp_percent', 5, 2)->nullable();
            $table->integer('fk_opp_status_end')->nullable();
            $table->dateTime('date_close')->nullable();
            $table->integer('fk_user_close')->nullable();
            $table->text('note_private')->nullable();
            $table->text('note_public')->nullable();
            $table->string('email_msgid', 175)->nullable();
            $table->double('opp_amount', 24, 8)->nullable();
            $table->double('budget_amount', 24, 8)->nullable();
            $table->integer('usage_opportunity')->nullable()->default(0);
            $table->integer('usage_task')->nullable()->default(1);
            $table->integer('usage_bill_time')->nullable()->default(0);
            $table->integer('usage_organize_event')->nullable()->default(0);
            $table->dateTime('date_start_event')->nullable();
            $table->dateTime('date_end_event')->nullable();
            $table->string('location')->nullable();
            $table->integer('accept_conference_suggestions')->nullable()->default(0);
            $table->integer('accept_booth_suggestions')->nullable()->default(0);
            $table->integer('max_attendees')->nullable()->default(0);
            $table->double('price_registration', 24, 8)->nullable();
            $table->double('price_booth', 24, 8)->nullable();
            $table->string('model_pdf')->nullable();
            $table->string('ip', 250)->nullable();
            $table->string('last_main_doc')->nullable();
            $table->string('import_key', 14)->nullable();
            $table->string('extraparams')->nullable();

            $table->unique(['ref', 'entity'], 'uk_projet_ref');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projet');
    }
};
