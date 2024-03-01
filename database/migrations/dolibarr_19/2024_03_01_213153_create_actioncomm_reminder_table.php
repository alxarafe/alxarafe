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
        Schema::create('actioncomm_reminder', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->dateTime('dateremind')->index('idx_actioncomm_reminder_dateremind');
            $table->string('typeremind', 32);
            $table->integer('fk_user')->index('idx_actioncomm_reminder_fk_user');
            $table->integer('offsetvalue');
            $table->string('offsetunit', 1);
            $table->integer('status')->default(0)->index('idx_actioncomm_reminder_status');
            $table->string('lasterror', 128)->nullable();
            $table->integer('entity')->default(1);
            $table->integer('fk_actioncomm');
            $table->integer('fk_email_template')->nullable();

            $table->unique(['fk_actioncomm', 'fk_user', 'typeremind', 'offsetvalue', 'offsetunit'], 'uk_actioncomm_reminder_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actioncomm_reminder');
    }
};
