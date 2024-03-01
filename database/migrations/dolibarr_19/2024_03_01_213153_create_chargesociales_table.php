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
        Schema::create('chargesociales', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('ref', 16)->nullable();
            $table->dateTime('date_ech');
            $table->string('libelle', 80);
            $table->integer('entity')->default(1);
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->dateTime('date_creation')->nullable();
            $table->dateTime('date_valid')->nullable();
            $table->integer('fk_user')->nullable();
            $table->integer('fk_user_author')->nullable();
            $table->integer('fk_user_modif')->nullable();
            $table->integer('fk_user_valid')->nullable();
            $table->integer('fk_type');
            $table->integer('fk_account')->nullable();
            $table->integer('fk_mode_reglement')->nullable();
            $table->double('amount', 24, 8)->default(0);
            $table->smallInteger('paye')->default(0);
            $table->date('periode')->nullable();
            $table->integer('fk_projet')->nullable();
            $table->text('note_private')->nullable();
            $table->text('note_public')->nullable();
            $table->string('import_key', 14)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chargesociales');
    }
};
