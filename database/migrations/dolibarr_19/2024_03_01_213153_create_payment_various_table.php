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
        Schema::create('payment_various', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('ref', 30)->nullable();
            $table->string('num_payment', 50)->nullable();
            $table->string('label')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->dateTime('datec')->nullable();
            $table->date('datep')->nullable();
            $table->date('datev')->nullable();
            $table->smallInteger('sens')->default(0);
            $table->double('amount', 24, 8)->default(0);
            $table->integer('fk_typepayment');
            $table->string('accountancy_code', 32)->nullable();
            $table->string('subledger_account', 32)->nullable();
            $table->integer('fk_projet')->nullable();
            $table->integer('entity')->default(1);
            $table->text('note')->nullable();
            $table->integer('fk_bank')->nullable();
            $table->integer('fk_user_author')->nullable();
            $table->integer('fk_user_modif')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_various');
    }
};
