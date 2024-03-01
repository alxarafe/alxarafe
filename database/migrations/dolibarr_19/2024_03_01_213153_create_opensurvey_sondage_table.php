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
        Schema::create('opensurvey_sondage', function (Blueprint $table) {
            $table->string('id_sondage', 16)->primary();
            $table->integer('entity')->default(1);
            $table->text('commentaires')->nullable();
            $table->string('mail_admin', 128)->nullable();
            $table->string('nom_admin', 64)->nullable();
            $table->integer('fk_user_creat');
            $table->text('titre');
            $table->dateTime('date_fin')->nullable()->index('idx_date_fin');
            $table->integer('status')->nullable()->default(1);
            $table->string('format', 2);
            $table->tinyInteger('mailsonde')->default(0);
            $table->tinyInteger('allow_comments')->default(1);
            $table->tinyInteger('allow_spy')->default(1);
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->text('sujet')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('opensurvey_sondage');
    }
};
