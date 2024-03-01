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
        Schema::table('recruitment_recruitmentcandidature', function (Blueprint $table) {
            $table->foreign(['fk_user_creat'], 'llx_recruitment_recruitmentcandidature_fk_user_creat')->references(['rowid'])->on('user')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recruitment_recruitmentcandidature', function (Blueprint $table) {
            $table->dropForeign('llx_recruitment_recruitmentcandidature_fk_user_creat');
        });
    }
};
