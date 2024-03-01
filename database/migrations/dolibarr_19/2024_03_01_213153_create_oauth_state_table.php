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
        Schema::create('oauth_state', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('service', 36)->nullable();
            $table->string('state', 128)->nullable();
            $table->integer('fk_user')->nullable();
            $table->integer('fk_adherent')->nullable();
            $table->integer('entity')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oauth_state');
    }
};
