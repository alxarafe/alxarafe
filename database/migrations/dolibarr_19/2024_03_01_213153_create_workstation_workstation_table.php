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
        Schema::create('workstation_workstation', function (Blueprint $table) {
            $table->integer('rowid', true)->index('idx_workstation_workstation_rowid');
            $table->string('ref', 128)->default('(PROV)')->index('idx_workstation_workstation_ref');
            $table->string('label')->nullable();
            $table->string('type', 7)->nullable();
            $table->text('note_public')->nullable();
            $table->integer('entity')->nullable()->default(1);
            $table->text('note_private')->nullable();
            $table->dateTime('date_creation');
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_user_creat')->index('fk_workstation_workstation_fk_user_creat');
            $table->integer('fk_user_modif')->nullable();
            $table->string('import_key', 14)->nullable();
            $table->smallInteger('status')->index('idx_workstation_workstation_status');
            $table->integer('nb_operators_required')->nullable();
            $table->double('thm_operator_estimated')->nullable();
            $table->double('thm_machine_estimated')->nullable();

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
        Schema::dropIfExists('workstation_workstation');
    }
};
