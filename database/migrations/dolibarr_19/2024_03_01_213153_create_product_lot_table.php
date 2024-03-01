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
        Schema::create('product_lot', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->nullable()->default(1);
            $table->integer('fk_product');
            $table->string('batch', 128)->nullable();
            $table->text('note_public')->nullable();
            $table->text('note_private')->nullable();
            $table->date('eatby')->nullable();
            $table->date('sellby')->nullable();
            $table->dateTime('eol_date')->nullable();
            $table->dateTime('manufacturing_date')->nullable();
            $table->dateTime('scrapping_date')->nullable();
            $table->integer('qc_frequency')->nullable();
            $table->integer('lifetime')->nullable();
            $table->string('barcode', 180)->nullable();
            $table->integer('fk_barcode_type')->nullable();
            $table->string('model_pdf')->nullable();
            $table->string('last_main_doc')->nullable();
            $table->dateTime('datec')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_user_creat')->nullable();
            $table->integer('fk_user_modif')->nullable();
            $table->integer('import_key')->nullable();

            $table->unique(['fk_product', 'batch'], 'uk_product_lot');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_lot');
    }
};
