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
        Schema::create('opensurvey_user_studs', function (Blueprint $table) {
            $table->integer('id_users', true)->index('idx_opensurvey_user_studs_id_users');
            $table->string('nom', 64)->index('idx_opensurvey_user_studs_nom');
            $table->string('id_sondage', 16)->index('idx_opensurvey_user_studs_id_sondage');
            $table->string('reponses', 200);
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->dateTime('date_creation');
            $table->string('ip', 250)->nullable();

            $table->primary(['id_users']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('opensurvey_user_studs');
    }
};
