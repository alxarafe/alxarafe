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
        Schema::create('user_employment', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(1);
            $table->string('ref', 50)->nullable();
            $table->string('ref_ext', 50)->nullable();
            $table->integer('fk_user')->nullable()->index('fk_user_employment_fk_user');
            $table->dateTime('datec')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_user_creat')->nullable();
            $table->integer('fk_user_modif')->nullable();
            $table->string('job', 128)->nullable();
            $table->integer('status');
            $table->double('salary', 24, 8)->nullable();
            $table->double('salaryextra', 24, 8)->nullable();
            $table->double('weeklyhours', 16, 8)->nullable();
            $table->date('dateemployment')->nullable();
            $table->date('dateemploymentend')->nullable();

            $table->unique(['ref', 'entity'], 'uk_user_employment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_employment');
    }
};
