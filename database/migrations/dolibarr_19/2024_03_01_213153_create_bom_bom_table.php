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
        Schema::create('bom_bom', function (Blueprint $table) {
            $table->integer('rowid', true)->index('idx_bom_bom_rowid');
            $table->integer('entity')->default(1);
            $table->string('ref', 128)->index('idx_bom_bom_ref');
            $table->integer('bomtype')->nullable()->default(0);
            $table->string('label')->nullable();
            $table->integer('fk_product')->nullable()->index('idx_bom_bom_fk_product');
            $table->text('description')->nullable();
            $table->text('note_public')->nullable();
            $table->text('note_private')->nullable();
            $table->integer('fk_warehouse')->nullable();
            $table->double('qty', 24, 8)->nullable();
            $table->double('efficiency', 24, 8)->nullable()->default(1);
            $table->double('duration', 24, 8)->nullable();
            $table->dateTime('date_creation');
            $table->dateTime('date_valid')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_user_creat')->index('llx_bom_bom_fk_user_creat');
            $table->integer('fk_user_modif')->nullable();
            $table->integer('fk_user_valid')->nullable();
            $table->string('import_key', 14)->nullable();
            $table->string('model_pdf')->nullable();
            $table->integer('status')->index('idx_bom_bom_status');

            $table->primary(['rowid']);
            $table->unique(['ref', 'entity'], 'uk_bom_bom_ref');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bom_bom');
    }
};
