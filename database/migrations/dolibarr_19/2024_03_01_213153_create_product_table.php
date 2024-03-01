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
        Schema::create('product', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('ref', 128);
            $table->integer('entity')->default(1);
            $table->string('ref_ext', 128)->nullable();
            $table->dateTime('datec')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_parent')->nullable()->default(0);
            $table->string('label')->index('idx_product_label');
            $table->text('description')->nullable();
            $table->text('note_public')->nullable();
            $table->text('note')->nullable();
            $table->string('customcode', 32)->nullable();
            $table->integer('fk_country')->nullable()->index('idx_product_fk_country');
            $table->integer('fk_state')->nullable();
            $table->double('price', 24, 8)->nullable()->default(0);
            $table->double('price_ttc', 24, 8)->nullable()->default(0);
            $table->double('price_min', 24, 8)->nullable()->default(0);
            $table->double('price_min_ttc', 24, 8)->nullable()->default(0);
            $table->string('price_base_type', 3)->nullable()->default('HT');
            $table->double('cost_price', 24, 8)->nullable();
            $table->string('default_vat_code', 10)->nullable();
            $table->double('tva_tx', 7, 4)->nullable();
            $table->integer('recuperableonly')->default(0);
            $table->double('localtax1_tx', 7, 4)->nullable()->default(0);
            $table->string('localtax1_type', 10)->default('0');
            $table->double('localtax2_tx', 7, 4)->nullable()->default(0);
            $table->string('localtax2_type', 10)->default('0');
            $table->integer('fk_user_author')->nullable()->index('idx_product_fk_user_author');
            $table->integer('fk_user_modif')->nullable();
            $table->tinyInteger('tosell')->nullable()->default(1);
            $table->tinyInteger('tobuy')->nullable()->default(1);
            $table->tinyInteger('onportal')->nullable()->default(0);
            $table->tinyInteger('tobatch')->default(0);
            $table->tinyInteger('sell_or_eat_by_mandatory')->default(0);
            $table->string('batch_mask', 32)->nullable();
            $table->integer('fk_product_type')->nullable()->default(0);
            $table->string('duration', 6)->nullable();
            $table->float('seuil_stock_alerte', 10, 0)->nullable()->index('idx_product_seuil_stock_alerte');
            $table->string('url')->nullable();
            $table->string('barcode', 180)->nullable()->index('idx_product_barcode');
            $table->integer('fk_barcode_type')->nullable()->index('idx_product_fk_barcode_type');
            $table->string('accountancy_code_sell', 32)->nullable();
            $table->string('accountancy_code_sell_intra', 32)->nullable();
            $table->string('accountancy_code_sell_export', 32)->nullable();
            $table->string('accountancy_code_buy', 32)->nullable();
            $table->string('accountancy_code_buy_intra', 32)->nullable();
            $table->string('accountancy_code_buy_export', 32)->nullable();
            $table->string('partnumber', 32)->nullable();
            $table->float('net_measure', 10, 0)->nullable();
            $table->tinyInteger('net_measure_units')->nullable();
            $table->float('weight', 10, 0)->nullable();
            $table->tinyInteger('weight_units')->nullable();
            $table->float('length', 10, 0)->nullable();
            $table->tinyInteger('length_units')->nullable();
            $table->float('width', 10, 0)->nullable();
            $table->tinyInteger('width_units')->nullable();
            $table->float('height', 10, 0)->nullable();
            $table->tinyInteger('height_units')->nullable();
            $table->float('surface', 10, 0)->nullable();
            $table->tinyInteger('surface_units')->nullable();
            $table->float('volume', 10, 0)->nullable();
            $table->tinyInteger('volume_units')->nullable();
            $table->integer('stockable_product')->default(1);
            $table->double('stock')->nullable();
            $table->double('pmp', 24, 8)->default(0);
            $table->double('fifo', 24, 8)->nullable();
            $table->double('lifo', 24, 8)->nullable();
            $table->integer('fk_default_warehouse')->nullable()->index('fk_product_default_warehouse');
            $table->string('canvas', 32)->nullable();
            $table->tinyInteger('finished')->nullable()->index('fk_product_finished');
            $table->integer('lifetime')->nullable();
            $table->integer('qc_frequency')->nullable();
            $table->tinyInteger('hidden')->nullable()->default(0);
            $table->string('import_key', 14)->nullable()->index('idx_product_import_key');
            $table->string('model_pdf')->nullable();
            $table->integer('fk_price_expression')->nullable();
            $table->float('desiredstock', 10, 0)->nullable()->default(0);
            $table->integer('fk_unit')->nullable()->index('fk_product_fk_unit');
            $table->tinyInteger('price_autogen')->nullable()->default(0);
            $table->integer('fk_project')->nullable()->index('idx_product_fk_project');
            $table->tinyInteger('mandatory_period')->nullable()->default(0);
            $table->integer('fk_default_bom')->nullable();
            $table->integer('fk_default_workstation')->nullable();

            $table->unique(['ref', 'entity'], 'uk_product_ref');
            $table->unique(['barcode', 'fk_barcode_type', 'entity'], 'uk_product_barcode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
};
