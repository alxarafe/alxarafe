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
        Schema::table('recruitment_recruitmentjobposition', function (Blueprint $table) {
            $table->foreign(['fk_establishment'], 'llx_recruitment_recruitmentjobposition_fk_establishment')->references(['rowid'])->on('establishment')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_user_creat'], 'llx_recruitment_recruitmentjobposition_fk_user_creat')->references(['rowid'])->on('user')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_user_recruiter'], 'llx_recruitment_recruitmentjobposition_fk_user_recruiter')->references(['rowid'])->on('user')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_user_supervisor'], 'llx_recruitment_recruitmentjobposition_fk_user_supervisor')->references(['rowid'])->on('user')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recruitment_recruitmentjobposition', function (Blueprint $table) {
            $table->dropForeign('llx_recruitment_recruitmentjobposition_fk_establishment');
            $table->dropForeign('llx_recruitment_recruitmentjobposition_fk_user_creat');
            $table->dropForeign('llx_recruitment_recruitmentjobposition_fk_user_recruiter');
            $table->dropForeign('llx_recruitment_recruitmentjobposition_fk_user_supervisor');
        });
    }
};
