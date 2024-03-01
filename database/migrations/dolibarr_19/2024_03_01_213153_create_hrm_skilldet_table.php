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
        Schema::create('hrm_skilldet', function (Blueprint $table) {
            $table->integer('rowid', true)->index('idx_hrm_skilldet_rowid');
            $table->integer('fk_skill')->index('llx_hrm_skilldet_fk_skill');
            $table->integer('rankorder')->default(1);
            $table->text('description')->nullable();
            $table->integer('fk_user_creat')->index('llx_hrm_skilldet_fk_user_creat');
            $table->integer('fk_user_modif')->nullable();

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
        Schema::dropIfExists('hrm_skilldet');
    }
};
