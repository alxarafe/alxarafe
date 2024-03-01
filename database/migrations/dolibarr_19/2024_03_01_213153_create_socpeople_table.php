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
        Schema::create('socpeople', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->dateTime('datec')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_soc')->nullable()->index('idx_socpeople_fk_soc');
            $table->integer('entity')->default(1);
            $table->string('ref_ext')->nullable();
            $table->string('civility', 6)->nullable();
            $table->string('lastname', 50)->nullable()->index('idx_socpeople_lastname');
            $table->string('firstname', 50)->nullable();
            $table->string('address')->nullable();
            $table->string('zip', 25)->nullable();
            $table->string('town')->nullable();
            $table->integer('fk_departement')->nullable();
            $table->integer('fk_pays')->nullable()->default(0);
            $table->date('birthday')->nullable();
            $table->string('poste')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('phone_perso', 30)->nullable();
            $table->string('phone_mobile', 30)->nullable();
            $table->string('fax', 30)->nullable();
            $table->string('email')->nullable();
            $table->text('socialnetworks')->nullable();
            $table->string('photo')->nullable();
            $table->smallInteger('no_email')->default(0);
            $table->smallInteger('priv')->default(0);
            $table->string('fk_prospectlevel', 12)->nullable();
            $table->integer('fk_stcommcontact')->default(0);
            $table->integer('fk_user_creat')->nullable()->default(0)->index('idx_socpeople_fk_user_creat');
            $table->integer('fk_user_modif')->nullable();
            $table->text('note_private')->nullable();
            $table->text('note_public')->nullable();
            $table->string('default_lang', 6)->nullable();
            $table->string('canvas', 32)->nullable();
            $table->string('import_key', 14)->nullable();
            $table->tinyInteger('statut')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('socpeople');
    }
};
