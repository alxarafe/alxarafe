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
        Schema::create('ecm_files', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('ref', 128)->nullable();
            $table->string('label', 128)->index('idx_ecm_files_label');
            $table->string('share', 128)->nullable();
            $table->string('share_pass', 32)->nullable();
            $table->integer('entity')->default(1);
            $table->string('filepath');
            $table->string('filename');
            $table->string('src_object_type', 64)->nullable();
            $table->integer('src_object_id')->nullable();
            $table->string('fullpath_orig', 750)->nullable();
            $table->text('description')->nullable();
            $table->string('keywords', 750)->nullable();
            $table->text('cover')->nullable();
            $table->integer('position')->nullable();
            $table->string('gen_or_uploaded', 12)->nullable();
            $table->string('extraparams')->nullable();
            $table->dateTime('date_c')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_user_c')->nullable();
            $table->integer('fk_user_m')->nullable();
            $table->text('note_private')->nullable();
            $table->text('note_public')->nullable();
            $table->text('acl')->nullable();

            $table->unique(['filepath', 'filename', 'entity'], 'uk_ecm_files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ecm_files');
    }
};
