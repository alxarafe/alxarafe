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
        Schema::create('adherent_type', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(1);
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->smallInteger('statut')->default(0);
            $table->string('libelle', 50);
            $table->string('morphy', 3);
            $table->string('duration', 6)->nullable();
            $table->string('subscription', 3)->default('1');
            $table->double('amount', 24, 8)->nullable();
            $table->integer('caneditamount')->nullable()->default(0);
            $table->string('vote', 3)->default('1');
            $table->text('note')->nullable();
            $table->text('mail_valid')->nullable();

            $table->unique(['libelle', 'entity'], 'uk_adherent_type_libelle');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adherent_type');
    }
};
