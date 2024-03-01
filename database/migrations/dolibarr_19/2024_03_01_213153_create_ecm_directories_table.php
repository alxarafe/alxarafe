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
        Schema::create('ecm_directories', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('label', 64);
            $table->integer('entity')->default(1);
            $table->integer('fk_parent')->nullable();
            $table->string('description');
            $table->integer('cachenbofdoc')->default(0);
            $table->string('fullpath', 750)->nullable();
            $table->string('extraparams')->nullable();
            $table->dateTime('date_c')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_user_c')->nullable()->index('idx_ecm_directories_fk_user_c');
            $table->integer('fk_user_m')->nullable()->index('idx_ecm_directories_fk_user_m');
            $table->text('note_private')->nullable();
            $table->text('note_public')->nullable();
            $table->text('acl')->nullable();

            $table->unique(['label', 'fk_parent', 'entity'], 'uk_ecm_directories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ecm_directories');
    }
};
