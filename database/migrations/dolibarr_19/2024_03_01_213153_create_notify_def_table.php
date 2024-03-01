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
        Schema::create('notify_def', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->date('datec')->nullable();
            $table->integer('fk_action');
            $table->integer('fk_soc')->nullable();
            $table->integer('fk_contact')->nullable();
            $table->integer('fk_user')->nullable();
            $table->string('email')->nullable();
            $table->double('threshold', 24, 8)->nullable();
            $table->string('context', 128)->nullable();
            $table->string('type', 16)->nullable()->default('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notify_def');
    }
};
