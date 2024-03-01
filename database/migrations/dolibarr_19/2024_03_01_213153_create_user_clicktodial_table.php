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
        Schema::create('user_clicktodial', function (Blueprint $table) {
            $table->integer('fk_user')->primary();
            $table->string('url')->nullable();
            $table->string('login', 32)->nullable();
            $table->string('pass', 64)->nullable();
            $table->string('poste', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_clicktodial');
    }
};
