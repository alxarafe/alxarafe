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
        Schema::create('user_param', function (Blueprint $table) {
            $table->integer('fk_user');
            $table->integer('entity')->default(1);
            $table->string('param', 180);
            $table->text('value');

            $table->unique(['fk_user', 'param', 'entity'], 'uk_user_param');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_param');
    }
};
