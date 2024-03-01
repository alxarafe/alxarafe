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
        Schema::create('hrm_skill', function (Blueprint $table) {
            $table->integer('rowid', true)->index('idx_hrm_skill_rowid');
            $table->string('label')->nullable();
            $table->text('description')->nullable();
            $table->dateTime('date_creation');
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_user_creat')->index('llx_hrm_skill_fk_user_creat');
            $table->integer('fk_user_modif')->nullable();
            $table->integer('required_level');
            $table->integer('date_validite');
            $table->double('temps_theorique', 24, 8);
            $table->integer('skill_type')->index('idx_hrm_skill_skill_type');
            $table->text('note_public')->nullable();
            $table->text('note_private')->nullable();

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
        Schema::dropIfExists('hrm_skill');
    }
};
