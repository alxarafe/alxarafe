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
        Schema::create('salary', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('ref', 30)->nullable();
            $table->string('ref_ext')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->dateTime('datec')->nullable();
            $table->integer('fk_user');
            $table->date('datep')->nullable();
            $table->date('datev')->nullable();
            $table->double('salary', 24, 8)->nullable();
            $table->double('amount', 24, 8)->default(0);
            $table->integer('fk_projet')->nullable();
            $table->integer('fk_typepayment');
            $table->string('num_payment', 50)->nullable();
            $table->string('label')->nullable();
            $table->date('datesp')->nullable();
            $table->date('dateep')->nullable();
            $table->integer('entity')->default(1);
            $table->text('note')->nullable();
            $table->text('note_public')->nullable();
            $table->integer('fk_bank')->nullable();
            $table->smallInteger('paye')->default(0);
            $table->integer('fk_account')->nullable();
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
        Schema::dropIfExists('salary');
    }
};
