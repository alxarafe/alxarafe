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
        Schema::create('multicurrency', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->dateTime('date_create')->nullable();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->integer('entity')->nullable()->default(1);
            $table->integer('fk_user')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('multicurrency');
    }
};
