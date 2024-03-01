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
        Schema::create('bookmark', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_user');
            $table->dateTime('dateb')->nullable();
            $table->text('url')->nullable();
            $table->string('target', 16)->nullable();
            $table->string('title', 64)->nullable();
            $table->string('favicon', 24)->nullable();
            $table->integer('position')->nullable()->default(0);
            $table->integer('entity')->default(1);

            $table->unique(['fk_user', 'entity', 'title'], 'uk_bookmark_title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookmark');
    }
};
