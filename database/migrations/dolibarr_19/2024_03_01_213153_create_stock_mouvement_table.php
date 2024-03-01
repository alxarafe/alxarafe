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
        Schema::create('stock_mouvement', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->dateTime('datem')->nullable();
            $table->integer('fk_product')->index('idx_stock_mouvement_fk_product');
            $table->string('batch', 128)->nullable();
            $table->date('eatby')->nullable();
            $table->date('sellby')->nullable();
            $table->integer('fk_entrepot')->index('idx_stock_mouvement_fk_entrepot');
            $table->double('value')->nullable();
            $table->double('price', 24, 8)->nullable()->default(0);
            $table->smallInteger('type_mouvement')->nullable();
            $table->integer('fk_user_author')->nullable();
            $table->string('label')->nullable();
            $table->string('inventorycode', 128)->nullable();
            $table->integer('fk_project')->nullable();
            $table->integer('fk_origin')->nullable();
            $table->string('origintype', 64)->nullable();
            $table->string('model_pdf')->nullable();
            $table->integer('fk_projet')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_mouvement');
    }
};
