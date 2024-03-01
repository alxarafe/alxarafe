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
        Schema::create('loan', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(1);
            $table->dateTime('datec')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->string('label', 80);
            $table->integer('fk_bank')->nullable();
            $table->double('capital', 24, 8)->default(0);
            $table->double('insurance_amount', 24, 8)->nullable()->default(0);
            $table->date('datestart')->nullable();
            $table->date('dateend')->nullable();
            $table->double('nbterm')->nullable();
            $table->double('rate');
            $table->text('note_private')->nullable();
            $table->text('note_public')->nullable();
            $table->double('capital_position', 24, 8)->nullable()->default(0);
            $table->date('date_position')->nullable();
            $table->smallInteger('paid')->default(0);
            $table->string('accountancy_account_capital', 32)->nullable();
            $table->string('accountancy_account_insurance', 32)->nullable();
            $table->string('accountancy_account_interest', 32)->nullable();
            $table->integer('fk_projet')->nullable();
            $table->integer('fk_user_author')->nullable();
            $table->integer('fk_user_modif')->nullable();
            $table->tinyInteger('active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan');
    }
};
