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
        Schema::create('bom_bomline', function (Blueprint $table) {
            $table->integer('rowid', true)->index('idx_bom_bomline_rowid');
            $table->integer('fk_bom')->index('idx_bom_bomline_fk_bom');
            $table->integer('fk_product')->index('idx_bom_bomline_fk_product');
            $table->integer('fk_bom_child')->nullable();
            $table->text('description')->nullable();
            $table->string('import_key', 14)->nullable();
            $table->double('qty', 24, 8);
            $table->smallInteger('qty_frozen')->nullable()->default(0);
            $table->smallInteger('disable_stock_change')->nullable()->default(0);
            $table->double('efficiency', 24, 8)->default(1);
            $table->integer('fk_unit')->nullable();
            $table->integer('position')->default(0);
            $table->integer('fk_default_workstation')->nullable();

            $table->primary(['rowid']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bom_bomline');
    }
};
