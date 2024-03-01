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
        Schema::create('opensurvey_user_formanswers', function (Blueprint $table) {
            $table->integer('fk_user_survey');
            $table->integer('fk_question');
            $table->text('reponses')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('opensurvey_user_formanswers');
    }
};
