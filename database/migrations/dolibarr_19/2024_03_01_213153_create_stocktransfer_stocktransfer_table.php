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
        Schema::create('stocktransfer_stocktransfer', function (Blueprint $table) {
            $table->integer('rowid', true)->index('idx_stocktransfer_stocktransfer_rowid');
            $table->integer('entity')->default(1);
            $table->string('ref', 128)->default('(PROV)')->index('idx_stocktransfer_stocktransfer_ref');
            $table->string('label')->nullable();
            $table->integer('fk_soc')->nullable()->index('idx_stocktransfer_stocktransfer_fk_soc');
            $table->integer('fk_project')->nullable()->index('idx_stocktransfer_stocktransfer_fk_project');
            $table->integer('fk_warehouse_source')->nullable();
            $table->integer('fk_warehouse_destination')->nullable();
            $table->text('description')->nullable();
            $table->text('note_public')->nullable();
            $table->text('note_private')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->dateTime('date_creation');
            $table->date('date_prevue_depart')->nullable();
            $table->date('date_reelle_depart')->nullable();
            $table->date('date_prevue_arrivee')->nullable();
            $table->date('date_reelle_arrivee')->nullable();
            $table->integer('lead_time_for_warning')->nullable();
            $table->integer('fk_user_creat')->index('llx_stocktransfer_stocktransfer_fk_user_creat');
            $table->integer('fk_user_modif')->nullable();
            $table->string('import_key', 14)->nullable();
            $table->string('model_pdf')->nullable();
            $table->string('last_main_doc')->nullable();
            $table->smallInteger('status')->index('idx_stocktransfer_stocktransfer_status');
            $table->integer('fk_incoterms')->nullable();
            $table->string('location_incoterms')->nullable();

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
        Schema::dropIfExists('stocktransfer_stocktransfer');
    }
};
