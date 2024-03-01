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
        Schema::create('overwrite_trans', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(1);
            $table->string('lang', 5)->nullable();
            $table->string('transkey', 128)->nullable();
            $table->text('transvalue')->nullable();

            $table->unique(['entity', 'lang', 'transkey'], 'uk_overwrite_trans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('overwrite_trans');
    }
};
