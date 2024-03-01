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
        Schema::table('payment_salary', function (Blueprint $table) {
            $table->foreign(['fk_user'], 'fk_payment_salary_user')->references(['rowid'])->on('user')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_salary', function (Blueprint $table) {
            $table->dropForeign('fk_payment_salary_user');
        });
    }
};
