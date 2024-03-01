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
        Schema::create('expedition', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->string('ref', 30);
            $table->integer('entity')->default(1);
            $table->integer('fk_soc')->index('idx_expedition_fk_soc');
            $table->integer('fk_projet')->nullable();
            $table->string('ref_ext')->nullable();
            $table->string('ref_customer')->nullable();
            $table->dateTime('date_creation')->nullable();
            $table->integer('fk_user_author')->nullable()->index('idx_expedition_fk_user_author');
            $table->integer('fk_user_modif')->nullable();
            $table->dateTime('date_valid')->nullable();
            $table->integer('fk_user_valid')->nullable()->index('idx_expedition_fk_user_valid');
            $table->dateTime('date_delivery')->nullable();
            $table->dateTime('date_expedition')->nullable();
            $table->integer('fk_address')->nullable();
            $table->integer('fk_shipping_method')->nullable()->index('idx_expedition_fk_shipping_method');
            $table->string('tracking_number', 50)->nullable();
            $table->smallInteger('fk_statut')->nullable()->default(0);
            $table->smallInteger('billed')->nullable()->default(0);
            $table->float('height', 10, 0)->nullable();
            $table->float('width', 10, 0)->nullable();
            $table->integer('size_units')->nullable();
            $table->float('size', 10, 0)->nullable();
            $table->integer('weight_units')->nullable();
            $table->float('weight', 10, 0)->nullable();
            $table->text('note_private')->nullable();
            $table->text('note_public')->nullable();
            $table->string('model_pdf')->nullable();
            $table->string('last_main_doc')->nullable();
            $table->integer('fk_incoterms')->nullable();
            $table->string('location_incoterms')->nullable();
            $table->string('import_key', 14)->nullable();
            $table->string('extraparams')->nullable();

            $table->unique(['ref', 'entity'], 'idx_expedition_uk_ref');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expedition');
    }
};
