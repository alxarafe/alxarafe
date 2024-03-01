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
        Schema::create('mrp_mo', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(1)->index('idx_mrp_mo_entity');
            $table->string('ref', 128)->default('(PROV)')->index('idx_mrp_mo_ref');
            $table->integer('mrptype')->nullable()->default(0);
            $table->string('label')->nullable();
            $table->double('qty');
            $table->integer('fk_warehouse')->nullable();
            $table->integer('fk_soc')->nullable()->index('idx_mrp_mo_fk_soc');
            $table->text('note_public')->nullable();
            $table->text('note_private')->nullable();
            $table->dateTime('date_creation');
            $table->dateTime('date_valid')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_user_creat')->index('fk_mrp_mo_fk_user_creat');
            $table->integer('fk_user_modif')->nullable();
            $table->integer('fk_user_valid')->nullable();
            $table->string('import_key', 14)->nullable();
            $table->string('model_pdf')->nullable();
            $table->integer('status')->index('idx_mrp_mo_status');
            $table->integer('fk_product')->index('idx_mrp_mo_fk_product');
            $table->dateTime('date_start_planned')->nullable()->index('idx_mrp_mo_date_start_planned');
            $table->dateTime('date_end_planned')->nullable()->index('idx_mrp_mo_date_end_planned');
            $table->integer('fk_bom')->nullable()->index('idx_mrp_mo_fk_bom');
            $table->integer('fk_project')->nullable()->index('idx_mrp_mo_fk_project');
            $table->string('last_main_doc')->nullable();
            $table->integer('fk_parent_line')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mrp_mo');
    }
};
