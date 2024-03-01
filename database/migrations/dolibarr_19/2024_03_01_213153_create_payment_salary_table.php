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
        Schema::create('payment_salary', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('ref', 30)->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->dateTime('datec')->nullable();
            $table->integer('fk_user')->nullable();
            $table->dateTime('datep')->nullable()->index('idx_payment_salary_datep');
            $table->date('datev')->nullable();
            $table->double('salary', 24, 8)->nullable();
            $table->double('amount', 24, 8)->default(0);
            $table->integer('fk_projet')->nullable();
            $table->integer('fk_typepayment');
            $table->string('num_payment', 50)->nullable()->index('idx_payment_salary_ref');
            $table->string('label')->nullable();
            $table->date('datesp')->nullable()->index('idx_payment_salary_datesp');
            $table->date('dateep')->nullable()->index('idx_payment_salary_dateep');
            $table->integer('entity')->default(1);
            $table->text('note')->nullable();
            $table->integer('fk_bank')->nullable();
            $table->integer('fk_user_author')->nullable();
            $table->integer('fk_user_modif')->nullable();
            $table->integer('fk_salary')->nullable();

            $table->index(['fk_user', 'entity'], 'idx_payment_salary_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_salary');
    }
};
