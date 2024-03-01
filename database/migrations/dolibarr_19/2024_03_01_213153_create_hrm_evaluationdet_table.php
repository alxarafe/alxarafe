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
        Schema::create('hrm_evaluationdet', function (Blueprint $table) {
            $table->integer('rowid', true)->index('idx_hrm_evaluationdet_rowid');
            $table->dateTime('date_creation');
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_user_creat')->index('llx_hrm_evaluationdet_fk_user_creat');
            $table->integer('fk_user_modif')->nullable();
            $table->integer('fk_skill')->index('idx_hrm_evaluationdet_fk_skill');
            $table->integer('fk_evaluation')->index('idx_hrm_evaluationdet_fk_evaluation');
            $table->integer('rankorder');
            $table->integer('required_rank');
            $table->text('comment')->nullable();
            $table->string('import_key', 14)->nullable();

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
        Schema::dropIfExists('hrm_evaluationdet');
    }
};
