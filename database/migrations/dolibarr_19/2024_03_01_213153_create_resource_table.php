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
        Schema::create('resource', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(1);
            $table->string('ref')->nullable();
            $table->string('asset_number')->nullable();
            $table->text('description')->nullable();
            $table->string('fk_code_type_resource', 32)->nullable()->index('fk_code_type_resource_idx');
            $table->string('address')->nullable();
            $table->string('zip', 25)->nullable();
            $table->string('town', 50)->nullable();
            $table->string('photo_filename')->nullable();
            $table->integer('max_users')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('url')->nullable();
            $table->dateTime('datec')->nullable();
            $table->dateTime('date_valid')->nullable();
            $table->integer('fk_user_author')->nullable();
            $table->integer('fk_user_modif')->nullable();
            $table->integer('fk_user_valid')->nullable();
            $table->smallInteger('fk_statut')->default(0);
            $table->text('note_public')->nullable();
            $table->text('note_private')->nullable();
            $table->string('import_key', 14)->nullable();
            $table->string('extraparams')->nullable();
            $table->integer('fk_country')->nullable()->index('idx_resource_fk_country');
            $table->integer('fk_state')->nullable()->index('idx_resource_fk_state');
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();

            $table->unique(['ref', 'entity'], 'uk_resource_ref');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resource');
    }
};
