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
        Schema::create('c_email_templates', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(1);
            $table->string('module', 32)->nullable();
            $table->string('type_template', 32)->nullable()->index('idx_type');
            $table->string('lang', 6)->nullable()->default('');
            $table->smallInteger('private')->default(0);
            $table->integer('fk_user')->nullable();
            $table->dateTime('datec')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->string('label', 180)->nullable();
            $table->smallInteger('position')->nullable();
            $table->smallInteger('defaultfortype')->nullable()->default(0);
            $table->string('enabled')->nullable()->default('1');
            $table->tinyInteger('active')->default(1);
            $table->string('email_from')->nullable();
            $table->string('email_to')->nullable();
            $table->string('email_tocc')->nullable();
            $table->string('email_tobcc')->nullable();
            $table->text('topic')->nullable();
            $table->text('joinfiles')->nullable();
            $table->mediumText('content')->nullable();
            $table->text('content_lines')->nullable();

            $table->unique(['entity', 'label', 'lang'], 'uk_c_email_templates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_email_templates');
    }
};
