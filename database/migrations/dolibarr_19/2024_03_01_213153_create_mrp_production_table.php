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
        Schema::create('mrp_production', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_mo')->index('idx_mrp_production_fk_mo');
            $table->integer('origin_id')->nullable();
            $table->string('origin_type', 10)->nullable();
            $table->integer('position')->default(0);
            $table->integer('fk_product')->index('fk_mrp_production_product');
            $table->integer('fk_warehouse')->nullable();
            $table->double('qty')->default(1);
            $table->smallInteger('qty_frozen')->nullable()->default(0);
            $table->smallInteger('disable_stock_change')->nullable()->default(0);
            $table->string('batch', 128)->nullable();
            $table->string('role', 10)->nullable();
            $table->integer('fk_mrp_production')->nullable();
            $table->integer('fk_stock_movement')->nullable()->index('fk_mrp_production_stock_movement');
            $table->dateTime('date_creation');
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_user_creat');
            $table->integer('fk_user_modif')->nullable();
            $table->string('import_key', 14)->nullable();
            $table->integer('fk_default_workstation')->nullable();
            $table->integer('fk_unit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mrp_production');
    }
};
