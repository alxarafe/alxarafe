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
        Schema::create('knowledgemanagement_knowledgerecord', function (Blueprint $table) {
            $table->integer('rowid', true)->index('idx_knowledgemanagement_knowledgerecord_rowid');
            $table->integer('entity')->default(1);
            $table->string('ref', 128)->index('idx_knowledgemanagement_knowledgerecord_ref');
            $table->dateTime('date_creation');
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->string('last_main_doc')->nullable();
            $table->string('lang', 6)->nullable();
            $table->integer('fk_user_creat')->index('llx_knowledgemanagement_knowledgerecord_fk_user_creat');
            $table->integer('fk_user_modif')->nullable();
            $table->integer('fk_user_valid')->nullable();
            $table->string('import_key', 14)->nullable();
            $table->string('model_pdf')->nullable();
            $table->text('question');
            $table->text('answer')->nullable();
            $table->string('url')->nullable();
            $table->integer('fk_ticket')->nullable();
            $table->integer('fk_c_ticket_category')->nullable();
            $table->integer('status')->index('idx_knowledgemanagement_knowledgerecord_status');

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
        Schema::dropIfExists('knowledgemanagement_knowledgerecord');
    }
};
