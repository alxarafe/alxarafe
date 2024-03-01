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
        Schema::create('delivery', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->string('ref', 30);
            $table->integer('entity')->default(1);
            $table->integer('fk_soc')->index('idx_delivery_fk_soc');
            $table->string('ref_ext')->nullable();
            $table->string('ref_customer')->nullable();
            $table->dateTime('date_creation')->nullable();
            $table->integer('fk_user_author')->nullable()->index('idx_delivery_fk_user_author');
            $table->dateTime('date_valid')->nullable();
            $table->integer('fk_user_valid')->nullable()->index('idx_delivery_fk_user_valid');
            $table->dateTime('date_delivery')->nullable();
            $table->integer('fk_address')->nullable();
            $table->smallInteger('fk_statut')->nullable()->default(0);
            $table->double('total_ht', 24, 8)->nullable()->default(0);
            $table->text('note_private')->nullable();
            $table->text('note_public')->nullable();
            $table->string('model_pdf')->nullable();
            $table->string('last_main_doc')->nullable();
            $table->integer('fk_incoterms')->nullable();
            $table->string('location_incoterms')->nullable();
            $table->string('import_key', 14)->nullable();
            $table->string('extraparams')->nullable();

            $table->unique(['ref', 'entity'], 'idx_delivery_uk_ref');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery');
    }
};
