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
        Schema::table('knowledgemanagement_knowledgerecord', function (Blueprint $table) {
            $table->foreign(['fk_user_creat'], 'llx_knowledgemanagement_knowledgerecord_fk_user_creat')->references(['rowid'])->on('user')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('knowledgemanagement_knowledgerecord', function (Blueprint $table) {
            $table->dropForeign('llx_knowledgemanagement_knowledgerecord_fk_user_creat');
        });
    }
};
