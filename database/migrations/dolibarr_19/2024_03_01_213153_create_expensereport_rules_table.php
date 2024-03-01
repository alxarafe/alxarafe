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
        Schema::create('expensereport_rules', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->dateTime('datec')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->dateTime('dates');
            $table->dateTime('datee');
            $table->double('amount', 24, 8);
            $table->tinyInteger('restrictive');
            $table->integer('fk_user')->nullable();
            $table->integer('fk_usergroup')->nullable();
            $table->integer('fk_c_type_fees');
            $table->string('code_expense_rules_type', 50);
            $table->tinyInteger('is_for_all')->nullable()->default(0);
            $table->integer('entity')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expensereport_rules');
    }
};
