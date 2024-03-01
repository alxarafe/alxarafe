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
        Schema::create('don', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('ref', 30)->nullable();
            $table->integer('entity')->default(1);
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->smallInteger('fk_statut')->default(0);
            $table->dateTime('datedon')->nullable();
            $table->double('amount', 24, 8)->nullable()->default(0);
            $table->integer('fk_payment')->nullable();
            $table->smallInteger('paid')->default(0);
            $table->integer('fk_soc')->nullable()->index('idx_don_fk_soc');
            $table->string('firstname', 50)->nullable();
            $table->string('lastname', 50)->nullable();
            $table->string('societe', 50)->nullable();
            $table->text('address')->nullable();
            $table->string('zip', 30)->nullable();
            $table->string('town', 50)->nullable();
            $table->string('country', 50)->nullable();
            $table->integer('fk_country');
            $table->string('email')->nullable();
            $table->string('phone', 24)->nullable();
            $table->string('phone_mobile', 24)->nullable();
            $table->smallInteger('public')->default(1);
            $table->integer('fk_projet')->nullable();
            $table->dateTime('datec')->nullable();
            $table->integer('fk_user_author')->index('idx_don_fk_user_author');
            $table->integer('fk_user_modif')->nullable();
            $table->dateTime('date_valid')->nullable();
            $table->integer('fk_user_valid')->nullable()->index('idx_don_fk_user_valid');
            $table->text('note_private')->nullable();
            $table->text('note_public')->nullable();
            $table->string('model_pdf')->nullable();
            $table->string('import_key', 14)->nullable();
            $table->string('extraparams')->nullable();

            $table->unique(['ref', 'entity'], 'idx_don_uk_ref');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('don');
    }
};
