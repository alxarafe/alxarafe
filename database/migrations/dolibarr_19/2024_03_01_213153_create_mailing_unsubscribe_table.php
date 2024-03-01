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
        Schema::create('mailing_unsubscribe', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(1);
            $table->string('email')->nullable();
            $table->string('unsubscribegroup', 128)->nullable()->default('');
            $table->string('ip', 128)->nullable();
            $table->dateTime('date_creat')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();

            $table->unique(['email', 'entity', 'unsubscribegroup'], 'uk_mailing_unsubscribe');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mailing_unsubscribe');
    }
};
