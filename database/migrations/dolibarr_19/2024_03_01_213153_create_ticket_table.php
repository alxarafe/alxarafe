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
        Schema::create('ticket', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->nullable()->default(1)->index('idx_ticket_entity');
            $table->string('ref', 128);
            $table->string('track_id', 128)->unique('uk_ticket_track_id');
            $table->integer('fk_soc')->nullable()->default(0)->index('idx_ticket_fk_soc');
            $table->integer('fk_project')->nullable()->default(0)->index('idx_ticket_fk_project');
            $table->integer('fk_contract')->nullable()->default(0);
            $table->string('origin_email', 128)->nullable();
            $table->integer('fk_user_create')->nullable();
            $table->integer('fk_user_assign')->nullable()->index('idx_ticket_fk_user_assign');
            $table->string('subject')->nullable();
            $table->mediumText('message')->nullable();
            $table->integer('fk_statut')->nullable()->index('idx_ticket_fk_statut');
            $table->integer('resolution')->nullable();
            $table->integer('progress')->nullable()->default(0);
            $table->string('timing', 20)->nullable();
            $table->string('type_code', 32)->nullable();
            $table->string('category_code', 32)->nullable();
            $table->string('severity_code', 32)->nullable();
            $table->dateTime('datec')->nullable();
            $table->dateTime('date_read')->nullable();
            $table->dateTime('date_last_msg_sent')->nullable();
            $table->dateTime('date_close')->nullable();
            $table->tinyInteger('notify_tiers_at_create')->nullable();
            $table->string('email_msgid')->nullable();
            $table->dateTime('email_date')->nullable();
            $table->string('ip', 250)->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->string('import_key', 14)->nullable();

            $table->unique(['ref', 'entity'], 'uk_ticket_ref');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket');
    }
};
