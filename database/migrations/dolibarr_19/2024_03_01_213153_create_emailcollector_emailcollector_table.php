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
        Schema::create('emailcollector_emailcollector', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(1)->index('idx_emailcollector_entity');
            $table->string('ref', 128);
            $table->string('label')->nullable();
            $table->text('description')->nullable();
            $table->string('host')->nullable();
            $table->string('port', 10)->nullable()->default('993');
            $table->string('hostcharset', 16)->nullable()->default('UTF-8');
            $table->string('imap_encryption', 16)->nullable()->default('ssl');
            $table->integer('norsh')->nullable()->default(0);
            $table->string('login', 128)->nullable();
            $table->integer('acces_type')->nullable()->default(0);
            $table->string('oauth_service', 128)->nullable();
            $table->string('password', 128)->nullable();
            $table->string('source_directory')->default('Inbox');
            $table->string('target_directory')->nullable();
            $table->integer('maxemailpercollect')->nullable()->default(100);
            $table->dateTime('datelastresult')->nullable();
            $table->string('codelastresult', 16)->nullable();
            $table->text('lastresult')->nullable();
            $table->dateTime('datelastok')->nullable();
            $table->text('note_public')->nullable();
            $table->text('note_private')->nullable();
            $table->dateTime('date_creation');
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_user_creat');
            $table->integer('fk_user_modif')->nullable();
            $table->integer('position')->default(0);
            $table->string('import_key', 14)->nullable();
            $table->integer('status')->index('idx_emailcollector_status');

            $table->unique(['ref', 'entity'], 'uk_emailcollector_emailcollector_ref');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emailcollector_emailcollector');
    }
};
