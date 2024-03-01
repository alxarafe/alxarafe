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
        Schema::create('loan_schedule', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_loan')->nullable();
            $table->dateTime('datec')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->dateTime('datep')->nullable();
            $table->double('amount_capital', 24, 8)->nullable()->default(0);
            $table->double('amount_insurance', 24, 8)->nullable()->default(0);
            $table->double('amount_interest', 24, 8)->nullable()->default(0);
            $table->integer('fk_typepayment');
            $table->string('num_payment', 50)->nullable();
            $table->text('note_private')->nullable();
            $table->text('note_public')->nullable();
            $table->integer('fk_bank');
            $table->integer('fk_payment_loan')->nullable();
            $table->integer('fk_user_creat')->nullable();
            $table->integer('fk_user_modif')->nullable();

            $table->unique(['fk_loan', 'datep'], 'uk_loan_schedule_ref');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_schedule');
    }
};
