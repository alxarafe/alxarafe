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
        Schema::create('user_rib', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_user');
            $table->integer('entity')->default(1);
            $table->dateTime('datec')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->string('label', 30)->nullable();
            $table->string('bank')->nullable();
            $table->string('code_banque', 128)->nullable();
            $table->string('code_guichet', 6)->nullable();
            $table->string('number')->nullable();
            $table->string('cle_rib', 5)->nullable();
            $table->string('bic', 11)->nullable();
            $table->string('bic_intermediate', 11)->nullable();
            $table->string('iban_prefix', 34)->nullable();
            $table->string('domiciliation')->nullable();
            $table->string('proprio', 60)->nullable();
            $table->string('owner_address')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('fk_country')->nullable();
            $table->string('currency_code', 3)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_rib');
    }
};
