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
        Schema::table('hrm_evaluationdet', function (Blueprint $table) {
            $table->foreign(['fk_evaluation'], 'llx_hrm_evaluationdet_fk_evaluation')->references(['rowid'])->on('hrm_evaluation')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_user_creat'], 'llx_hrm_evaluationdet_fk_user_creat')->references(['rowid'])->on('user')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrm_evaluationdet', function (Blueprint $table) {
            $table->dropForeign('llx_hrm_evaluationdet_fk_evaluation');
            $table->dropForeign('llx_hrm_evaluationdet_fk_user_creat');
        });
    }
};
