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
        Schema::create('hrm_skillrank', function (Blueprint $table) {
            $table->integer('rowid', true)->index('idx_hrm_skillrank_rowid');
            $table->integer('fk_skill')->index('idx_hrm_skillrank_fk_skill');
            $table->integer('rankorder');
            $table->integer('fk_object');
            $table->dateTime('date_creation');
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_user_creat')->index('llx_hrm_skillrank_fk_user_creat');
            $table->integer('fk_user_modif')->nullable();
            $table->string('objecttype', 128);

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
        Schema::dropIfExists('hrm_skillrank');
    }
};
