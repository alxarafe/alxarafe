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
        Schema::create('pos_cash_fence', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(1);
            $table->string('ref', 64)->nullable();
            $table->string('label')->nullable();
            $table->double('opening', 24, 8)->nullable()->default(0);
            $table->double('cash', 24, 8)->nullable()->default(0);
            $table->double('card', 24, 8)->nullable()->default(0);
            $table->double('cheque', 24, 8)->nullable()->default(0);
            $table->integer('status')->nullable();
            $table->dateTime('date_creation');
            $table->dateTime('date_valid')->nullable();
            $table->integer('day_close')->nullable();
            $table->integer('month_close')->nullable();
            $table->integer('year_close')->nullable();
            $table->string('posmodule', 30)->nullable();
            $table->string('posnumber', 30)->nullable();
            $table->integer('fk_user_creat')->nullable();
            $table->integer('fk_user_valid')->nullable();
            $table->timestamp('tms')->nullable();
            $table->string('import_key', 14)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pos_cash_fence');
    }
};
