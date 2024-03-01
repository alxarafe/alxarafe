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
        Schema::create('contratdet', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_contrat')->index('idx_contratdet_fk_contrat');
            $table->integer('fk_product')->nullable()->index('idx_contratdet_fk_product');
            $table->smallInteger('statut')->nullable()->default(0)->index('idx_contratdet_statut');
            $table->text('label')->nullable();
            $table->text('description')->nullable();
            $table->integer('fk_remise_except')->nullable();
            $table->dateTime('date_commande')->nullable();
            $table->dateTime('date_ouverture_prevue')->nullable()->index('idx_contratdet_date_ouverture_prevue');
            $table->dateTime('date_ouverture')->nullable()->index('idx_contratdet_date_ouverture');
            $table->dateTime('date_fin_validite')->nullable()->index('idx_contratdet_date_fin_validite');
            $table->dateTime('date_cloture')->nullable();
            $table->string('vat_src_code', 10)->nullable()->default('');
            $table->double('tva_tx', 7, 4)->nullable()->default(0);
            $table->double('localtax1_tx', 7, 4)->nullable()->default(0);
            $table->string('localtax1_type', 10)->nullable();
            $table->double('localtax2_tx', 7, 4)->nullable()->default(0);
            $table->string('localtax2_type', 10)->nullable();
            $table->double('qty');
            $table->double('remise_percent')->nullable()->default(0);
            $table->double('subprice', 24, 8)->nullable()->default(0);
            $table->double('price_ht')->nullable();
            $table->double('remise')->nullable()->default(0);
            $table->double('total_ht', 24, 8)->nullable()->default(0);
            $table->double('total_tva', 24, 8)->nullable()->default(0);
            $table->double('total_localtax1', 24, 8)->nullable()->default(0);
            $table->double('total_localtax2', 24, 8)->nullable()->default(0);
            $table->double('total_ttc', 24, 8)->nullable()->default(0);
            $table->integer('product_type')->nullable()->default(1);
            $table->integer('info_bits')->nullable()->default(0);
            $table->integer('rang')->nullable()->default(0);
            $table->double('buy_price_ht', 24, 8)->nullable();
            $table->integer('fk_product_fournisseur_price')->nullable();
            $table->integer('fk_user_author')->default(0);
            $table->integer('fk_user_ouverture')->nullable();
            $table->integer('fk_user_cloture')->nullable();
            $table->text('commentaire')->nullable();
            $table->integer('fk_unit')->nullable()->index('fk_contratdet_fk_unit');
            $table->integer('fk_multicurrency')->nullable();
            $table->string('multicurrency_code', 3)->nullable();
            $table->double('multicurrency_subprice', 24, 8)->nullable()->default(0);
            $table->double('multicurrency_total_ht', 24, 8)->nullable()->default(0);
            $table->double('multicurrency_total_tva', 24, 8)->nullable()->default(0);
            $table->double('multicurrency_total_ttc', 24, 8)->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contratdet');
    }
};
