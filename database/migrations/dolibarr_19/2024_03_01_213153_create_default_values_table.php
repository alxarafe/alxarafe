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
        Schema::create('default_values', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(1);
            $table->string('type', 10)->nullable();
            $table->integer('user_id')->default(0);
            $table->string('page')->nullable();
            $table->string('param')->nullable();
            $table->string('value', 128)->nullable();

            $table->unique(['type', 'entity', 'user_id', 'page', 'param'], 'uk_default_values');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('default_values');
    }
};
