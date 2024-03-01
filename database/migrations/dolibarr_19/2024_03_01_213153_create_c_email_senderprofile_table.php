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
        Schema::create('c_email_senderprofile', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(1);
            $table->smallInteger('private')->default(0);
            $table->dateTime('date_creation')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->string('label')->nullable();
            $table->string('email');
            $table->text('signature')->nullable();
            $table->smallInteger('position')->nullable()->default(0);
            $table->tinyInteger('active')->default(1);

            $table->unique(['entity', 'label', 'email'], 'uk_c_email_senderprofile');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_email_senderprofile');
    }
};
