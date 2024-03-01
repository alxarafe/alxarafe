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
        Schema::create('adherent', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('ref', 30);
            $table->integer('entity')->default(1);
            $table->string('ref_ext', 128)->nullable();
            $table->string('gender', 10)->nullable();
            $table->string('civility', 6)->nullable();
            $table->string('lastname', 50)->nullable();
            $table->string('firstname', 50)->nullable();
            $table->string('login', 50)->nullable();
            $table->string('pass', 50)->nullable();
            $table->string('pass_crypted', 128)->nullable();
            $table->integer('fk_adherent_type')->index('idx_adherent_fk_adherent_type');
            $table->string('morphy', 3);
            $table->string('societe', 128)->nullable();
            $table->integer('fk_soc')->nullable()->unique('uk_adherent_fk_soc');
            $table->text('address')->nullable();
            $table->string('zip', 30)->nullable();
            $table->string('town', 50)->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('country')->nullable();
            $table->string('email')->nullable();
            $table->string('url')->nullable();
            $table->text('socialnetworks')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('phone_perso', 30)->nullable();
            $table->string('phone_mobile', 30)->nullable();
            $table->date('birth')->nullable();
            $table->string('photo')->nullable();
            $table->smallInteger('statut')->default(0);
            $table->smallInteger('public')->default(0);
            $table->dateTime('datefin')->nullable();
            $table->string('default_lang', 6)->nullable();
            $table->text('note_private')->nullable();
            $table->text('note_public')->nullable();
            $table->string('model_pdf')->nullable();
            $table->dateTime('datevalid')->nullable();
            $table->dateTime('datec')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_user_author')->nullable();
            $table->integer('fk_user_mod')->nullable();
            $table->integer('fk_user_valid')->nullable();
            $table->string('canvas', 32)->nullable();
            $table->string('ip', 250)->nullable();
            $table->string('import_key', 14)->nullable();

            $table->unique(['login', 'entity'], 'uk_adherent_login');
            $table->unique(['ref', 'entity'], 'uk_adherent_ref');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adherent');
    }
};
