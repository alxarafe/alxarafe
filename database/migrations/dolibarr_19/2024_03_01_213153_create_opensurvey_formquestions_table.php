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
        Schema::create('opensurvey_formquestions', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('id_sondage', 16)->nullable();
            $table->text('question')->nullable();
            $table->text('available_answers')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('opensurvey_formquestions');
    }
};
