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
        Schema::create('product_customer_price_log', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(1);
            $table->dateTime('datec')->nullable();
            $table->integer('fk_product');
            $table->integer('fk_soc')->default(0);
            $table->string('ref_customer', 30)->nullable();
            $table->double('price', 24, 8)->nullable()->default(0);
            $table->double('price_ttc', 24, 8)->nullable()->default(0);
            $table->double('price_min', 24, 8)->nullable()->default(0);
            $table->double('price_min_ttc', 24, 8)->nullable()->default(0);
            $table->string('price_base_type', 3)->nullable()->default('HT');
            $table->string('default_vat_code', 10)->nullable();
            $table->double('tva_tx', 7, 4)->nullable();
            $table->integer('recuperableonly')->default(0);
            $table->double('localtax1_tx', 7, 4)->nullable()->default(0);
            $table->string('localtax1_type', 10)->default('0');
            $table->double('localtax2_tx', 7, 4)->nullable()->default(0);
            $table->string('localtax2_type', 10)->default('0');
            $table->integer('fk_user')->nullable();
            $table->string('import_key', 14)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_customer_price_log');
    }
};
