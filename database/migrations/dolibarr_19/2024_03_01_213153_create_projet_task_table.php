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
        Schema::create('projet_task', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('ref', 50)->nullable();
            $table->integer('entity')->default(1);
            $table->integer('fk_projet')->index('idx_projet_task_fk_projet');
            $table->integer('fk_task_parent')->default(0);
            $table->dateTime('datec')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->dateTime('dateo')->nullable();
            $table->dateTime('datee')->nullable();
            $table->dateTime('datev')->nullable();
            $table->string('label');
            $table->text('description')->nullable();
            $table->double('duration_effective')->nullable()->default(0);
            $table->double('planned_workload')->nullable()->default(0);
            $table->integer('progress')->nullable()->default(0);
            $table->integer('priority')->nullable()->default(0);
            $table->double('budget_amount', 24, 8)->nullable();
            $table->integer('fk_user_creat')->nullable()->index('idx_projet_task_fk_user_creat');
            $table->integer('fk_user_modif')->nullable();
            $table->integer('fk_user_valid')->nullable()->index('idx_projet_task_fk_user_valid');
            $table->smallInteger('fk_statut')->default(0);
            $table->text('note_private')->nullable();
            $table->text('note_public')->nullable();
            $table->integer('rang')->nullable()->default(0);
            $table->string('model_pdf')->nullable();
            $table->string('import_key', 14)->nullable();
            $table->integer('status')->default(1);

            $table->unique(['ref', 'entity'], 'uk_projet_task_ref');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projet_task');
    }
};
