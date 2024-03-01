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
        Schema::create('fichinterdet_rec', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_fichinter');
            $table->dateTime('date')->nullable();
            $table->text('description')->nullable();
            $table->integer('duree')->nullable();
            $table->integer('rang')->nullable()->default(0);
            $table->double('total_ht', 24, 8)->nullable();
            $table->double('subprice', 24, 8)->nullable();
            $table->integer('fk_parent_line')->nullable();
            $table->integer('fk_product')->nullable();
            $table->string('label')->nullable();
            $table->double('tva_tx', 6, 3)->nullable();
            $table->double('localtax1_tx', 6, 3)->nullable()->default(0);
            $table->string('localtax1_type', 1)->nullable();
            $table->double('localtax2_tx', 6, 3)->nullable()->default(0);
            $table->string('localtax2_type', 1)->nullable();
            $table->double('qty')->nullable();
            $table->double('remise_percent')->nullable()->default(0);
            $table->integer('fk_remise_except')->nullable();
            $table->double('price', 24, 8)->nullable();
            $table->double('total_tva', 24, 8)->nullable();
            $table->double('total_localtax1', 24, 8)->nullable()->default(0);
            $table->double('total_localtax2', 24, 8)->nullable()->default(0);
            $table->double('total_ttc', 24, 8)->nullable();
            $table->integer('product_type')->nullable()->default(0);
            $table->dateTime('date_start')->nullable();
            $table->dateTime('date_end')->nullable();
            $table->integer('info_bits')->nullable()->default(0);
            $table->double('buy_price_ht', 24, 8)->nullable()->default(0);
            $table->integer('fk_product_fournisseur_price')->nullable();
            $table->integer('fk_code_ventilation')->default(0);
            $table->unsignedInteger('special_code')->nullable()->default(0);
            $table->integer('fk_unit')->nullable();
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
        Schema::dropIfExists('fichinterdet_rec');
    }
};
