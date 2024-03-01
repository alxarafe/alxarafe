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
        Schema::create('opensurvey_comments', function (Blueprint $table) {
            $table->increments('id_comment')->index('idx_id_comment');
            $table->char('id_sondage', 16)->index('idx_id_sondage');
            $table->text('comment');
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->text('usercomment')->nullable();
            $table->dateTime('date_creation');
            $table->string('ip', 250)->nullable();

            $table->primary(['id_comment']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('opensurvey_comments');
    }
};
