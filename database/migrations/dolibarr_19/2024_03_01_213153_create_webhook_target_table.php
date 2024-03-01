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
        Schema::create('webhook_target', function (Blueprint $table) {
            $table->integer('rowid', true)->index('idx_webhook_target_rowid');
            $table->string('ref', 128)->index('idx_webhook_target_ref');
            $table->string('label')->nullable();
            $table->text('description')->nullable();
            $table->text('note_public')->nullable();
            $table->text('note_private')->nullable();
            $table->dateTime('date_creation');
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_user_creat')->index('llx_webhook_target_fk_user_creat');
            $table->integer('fk_user_modif')->nullable();
            $table->string('import_key', 14)->nullable();
            $table->integer('status')->default(0)->index('idx_webhook_target_status');
            $table->string('url');
            $table->string('connection_method')->nullable();
            $table->string('connection_data')->nullable();
            $table->text('trigger_codes')->nullable();

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
        Schema::dropIfExists('webhook_target');
    }
};
