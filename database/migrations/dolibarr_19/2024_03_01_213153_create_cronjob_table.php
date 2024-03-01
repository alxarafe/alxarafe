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
        Schema::create('cronjob', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->dateTime('datec')->nullable();
            $table->string('jobtype', 10);
            $table->string('label');
            $table->string('command')->nullable();
            $table->string('classesname')->nullable();
            $table->string('objectname')->nullable();
            $table->string('methodename')->nullable();
            $table->text('params')->nullable();
            $table->string('md5params', 32)->nullable();
            $table->string('module_name')->nullable();
            $table->integer('priority')->nullable()->default(0);
            $table->dateTime('datelastrun')->nullable()->index('idx_cronjob_datelastrun');
            $table->dateTime('datenextrun')->nullable()->index('idx_cronjob_datenextrun');
            $table->dateTime('datestart')->nullable()->index('idx_cronjob_datestart');
            $table->dateTime('dateend')->nullable()->index('idx_cronjob_dateend');
            $table->dateTime('datelastresult')->nullable();
            $table->text('lastresult')->nullable();
            $table->text('lastoutput')->nullable();
            $table->string('unitfrequency')->default('3600');
            $table->integer('frequency')->default(0);
            $table->integer('maxrun')->default(0);
            $table->integer('nbrun')->nullable();
            $table->integer('autodelete')->nullable()->default(0);
            $table->integer('status')->default(1)->index('idx_cronjob_status');
            $table->integer('processing')->default(0);
            $table->integer('pid')->nullable();
            $table->string('test')->nullable()->default('1');
            $table->integer('fk_user_author')->nullable();
            $table->integer('fk_user_mod')->nullable();
            $table->integer('fk_mailing')->nullable();
            $table->text('note')->nullable();
            $table->string('libname')->nullable();
            $table->string('email_alert', 128)->nullable();
            $table->integer('entity')->nullable()->default(0);

            $table->unique(['label', 'entity'], 'uk_cronjob');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cronjob');
    }
};
