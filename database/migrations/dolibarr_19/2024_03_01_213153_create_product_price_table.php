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
        Schema::create('product_price', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(1);
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_product')->index('idx_product_price_fk_product');
            $table->dateTime('date_price');
            $table->smallInteger('price_level')->nullable()->default(1);
            $table->double('price', 24, 8)->nullable();
            $table->double('price_ttc', 24, 8)->nullable();
            $table->double('price_min', 24, 8)->nullable();
            $table->double('price_min_ttc', 24, 8)->nullable();
            $table->string('price_base_type', 3)->nullable()->default('HT');
            $table->string('default_vat_code', 10)->nullable();
            $table->double('tva_tx', 7, 4)->default(0);
            $table->integer('recuperableonly')->default(0);
            $table->double('localtax1_tx', 7, 4)->nullable()->default(0);
            $table->string('localtax1_type', 10)->default('0');
            $table->double('localtax2_tx', 7, 4)->nullable()->default(0);
            $table->string('localtax2_type', 10)->default('0');
            $table->integer('fk_user_author')->nullable()->index('idx_product_price_fk_user_author');
            $table->tinyInteger('tosell')->nullable()->default(1);
            $table->integer('price_by_qty')->default(0);
            $table->integer('fk_price_expression')->nullable();
            $table->string('import_key', 14)->nullable();
            $table->integer('fk_multicurrency')->nullable();
            $table->string('multicurrency_code', 3)->nullable();
            $table->double('multicurrency_tx', 24, 8)->nullable()->default(1);
            $table->double('multicurrency_price', 24, 8)->nullable();
            $table->double('multicurrency_price_ttc', 24, 8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_price');
    }
};
