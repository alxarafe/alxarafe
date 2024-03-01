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
        Schema::create('events', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->string('type', 32);
            $table->integer('entity')->default(1);
            $table->string('prefix_session')->nullable();
            $table->dateTime('dateevent')->nullable()->index('idx_events_dateevent');
            $table->integer('fk_user')->nullable();
            $table->string('description', 250);
            $table->string('ip', 250);
            $table->string('user_agent')->nullable();
            $table->integer('fk_object')->nullable();
            $table->string('authentication_method', 64)->nullable();
            $table->integer('fk_oauth_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
};
