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
        Schema::create('oauth_token', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('service', 36)->nullable();
            $table->text('token')->nullable();
            $table->text('tokenstring')->nullable();
            $table->text('state')->nullable();
            $table->integer('fk_soc')->nullable();
            $table->integer('fk_user')->nullable();
            $table->integer('fk_adherent')->nullable();
            $table->string('restricted_ips', 200)->nullable();
            $table->dateTime('datec')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
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
        Schema::dropIfExists('oauth_token');
    }
};
