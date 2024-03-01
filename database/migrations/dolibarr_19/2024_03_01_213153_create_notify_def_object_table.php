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
        Schema::create('notify_def_object', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('entity')->default(1);
            $table->string('objet_type', 16)->nullable();
            $table->integer('objet_id');
            $table->string('type_notif', 16)->nullable()->default('browser');
            $table->dateTime('date_notif')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('moreparam')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notify_def_object');
    }
};
