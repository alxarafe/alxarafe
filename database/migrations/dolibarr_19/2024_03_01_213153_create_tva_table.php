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
        Schema::create('tva', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->dateTime('datec')->nullable();
            $table->date('datep')->nullable();
            $table->date('datev')->nullable();
            $table->double('amount', 24, 8)->default(0);
            $table->integer('fk_typepayment')->nullable();
            $table->string('num_payment', 50)->nullable();
            $table->string('label')->nullable();
            $table->integer('entity')->default(1);
            $table->text('note')->nullable();
            $table->smallInteger('paye')->default(0);
            $table->integer('fk_account')->nullable();
            $table->integer('fk_user_creat')->nullable();
            $table->integer('fk_user_modif')->nullable();
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
        Schema::dropIfExists('tva');
    }
};
