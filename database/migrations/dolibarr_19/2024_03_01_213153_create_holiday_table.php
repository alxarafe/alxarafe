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
        Schema::create('holiday', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('ref', 30);
            $table->string('ref_ext')->nullable();
            $table->integer('entity')->default(1)->index('idx_holiday_entity');
            $table->integer('fk_user')->index('idx_holiday_fk_user');
            $table->integer('fk_user_create')->nullable()->index('idx_holiday_fk_user_create');
            $table->integer('fk_user_modif')->nullable();
            $table->integer('fk_type');
            $table->dateTime('date_create')->index('idx_holiday_date_create');
            $table->string('description');
            $table->date('date_debut')->index('idx_holiday_date_debut');
            $table->date('date_fin')->index('idx_holiday_date_fin');
            $table->integer('halfday')->nullable()->default(0);
            $table->double('nb_open_day', 24, 8)->nullable();
            $table->integer('statut')->default(1);
            $table->integer('fk_validator')->index('idx_holiday_fk_validator');
            $table->dateTime('date_valid')->nullable();
            $table->integer('fk_user_valid')->nullable();
            $table->dateTime('date_approval')->nullable();
            $table->integer('fk_user_approve')->nullable();
            $table->dateTime('date_refuse')->nullable();
            $table->integer('fk_user_refuse')->nullable();
            $table->dateTime('date_cancel')->nullable();
            $table->integer('fk_user_cancel')->nullable();
            $table->string('detail_refuse', 250)->nullable();
            $table->text('note_private')->nullable();
            $table->text('note_public')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->string('import_key', 14)->nullable();
            $table->string('extraparams')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('holiday');
    }
};
