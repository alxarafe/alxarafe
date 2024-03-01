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
        Schema::create('expensereport_det', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_expensereport');
            $table->string('docnumber', 128)->nullable();
            $table->integer('fk_c_type_fees');
            $table->integer('fk_c_exp_tax_cat')->nullable();
            $table->integer('fk_projet')->nullable();
            $table->text('comments');
            $table->integer('product_type')->nullable()->default(-1);
            $table->double('qty');
            $table->double('subprice', 24, 8)->default(0);
            $table->double('value_unit', 24, 8);
            $table->double('remise_percent')->nullable();
            $table->string('vat_src_code', 10)->nullable()->default('');
            $table->double('tva_tx', 7, 4)->nullable();
            $table->double('localtax1_tx', 7, 4)->nullable()->default(0);
            $table->string('localtax1_type', 10)->nullable();
            $table->double('localtax2_tx', 7, 4)->nullable()->default(0);
            $table->string('localtax2_type', 10)->nullable();
            $table->double('total_ht', 24, 8)->default(0);
            $table->double('total_tva', 24, 8)->default(0);
            $table->double('total_localtax1', 24, 8)->nullable()->default(0);
            $table->double('total_localtax2', 24, 8)->nullable()->default(0);
            $table->double('total_ttc', 24, 8)->default(0);
            $table->date('date');
            $table->integer('info_bits')->nullable()->default(0);
            $table->integer('special_code')->nullable()->default(0);
            $table->integer('fk_multicurrency')->nullable();
            $table->string('multicurrency_code', 3)->nullable();
            $table->double('multicurrency_subprice', 24, 8)->nullable()->default(0);
            $table->double('multicurrency_total_ht', 24, 8)->nullable()->default(0);
            $table->double('multicurrency_total_tva', 24, 8)->nullable()->default(0);
            $table->double('multicurrency_total_ttc', 24, 8)->nullable()->default(0);
            $table->integer('fk_facture')->nullable()->default(0);
            $table->integer('fk_ecm_files')->nullable();
            $table->integer('fk_code_ventilation')->nullable()->default(0);
            $table->integer('rang')->nullable()->default(0);
            $table->string('import_key', 14)->nullable();
            $table->text('rule_warning_message')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expensereport_det');
    }
};
