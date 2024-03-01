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
        Schema::create('prelevement_bons', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('type', 16)->nullable()->default('debit-order');
            $table->string('ref', 12)->nullable();
            $table->integer('entity')->default(1);
            $table->dateTime('datec')->nullable();
            $table->double('amount', 24, 8)->nullable()->default(0);
            $table->smallInteger('statut')->nullable()->default(0);
            $table->smallInteger('credite')->nullable()->default(0);
            $table->text('note')->nullable();
            $table->dateTime('date_trans')->nullable();
            $table->smallInteger('method_trans')->nullable();
            $table->integer('fk_user_trans')->nullable();
            $table->dateTime('date_credit')->nullable();
            $table->integer('fk_user_credit')->nullable();
            $table->integer('fk_bank_account')->nullable();

            $table->unique(['ref', 'entity'], 'uk_prelevement_bons_ref');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prelevement_bons');
    }
};
