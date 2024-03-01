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
        Schema::create('societe', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('nom', 128)->nullable()->index('idx_societe_nom');
            $table->string('name_alias', 128)->nullable();
            $table->integer('entity')->default(1);
            $table->string('ref_ext')->nullable();
            $table->tinyInteger('statut')->nullable()->default(0);
            $table->integer('parent')->nullable();
            $table->tinyInteger('status')->nullable()->default(1);
            $table->string('code_client', 24)->nullable();
            $table->string('code_fournisseur', 24)->nullable();
            $table->string('code_compta', 24)->nullable();
            $table->string('code_compta_fournisseur', 24)->nullable();
            $table->string('address')->nullable();
            $table->string('zip', 25)->nullable();
            $table->string('town', 50)->nullable();
            $table->integer('fk_departement')->nullable()->default(0);
            $table->integer('fk_pays')->nullable()->default(0)->index('idx_societe_pays');
            $table->integer('fk_account')->nullable()->default(0)->index('idx_societe_account');
            $table->string('phone', 20)->nullable();
            $table->string('fax', 20)->nullable();
            $table->string('url')->nullable();
            $table->string('email', 128)->nullable();
            $table->text('socialnetworks')->nullable();
            $table->integer('fk_effectif')->nullable()->default(0);
            $table->integer('fk_typent')->nullable()->index('idx_societe_typent');
            $table->integer('fk_forme_juridique')->nullable()->default(0)->index('idx_societe_forme_juridique');
            $table->string('fk_currency', 3)->nullable();
            $table->string('siren', 128)->nullable();
            $table->string('siret', 128)->nullable();
            $table->string('ape', 128)->nullable();
            $table->string('idprof4', 128)->nullable();
            $table->string('idprof5', 128)->nullable();
            $table->string('idprof6', 128)->nullable();
            $table->string('tva_intra', 20)->nullable();
            $table->double('capital', 24, 8)->nullable();
            $table->integer('fk_stcomm')->default(0)->index('idx_societe_stcomm');
            $table->text('note_private')->nullable();
            $table->text('note_public')->nullable();
            $table->string('model_pdf')->nullable();
            $table->string('last_main_doc')->nullable();
            $table->string('prefix_comm', 5)->nullable();
            $table->tinyInteger('client')->nullable()->default(0);
            $table->tinyInteger('fournisseur')->nullable()->default(0);
            $table->string('supplier_account', 32)->nullable();
            $table->string('fk_prospectlevel', 12)->nullable()->index('idx_societe_prospectlevel');
            $table->integer('fk_incoterms')->nullable();
            $table->string('location_incoterms')->nullable();
            $table->tinyInteger('customer_bad')->nullable()->default(0);
            $table->double('customer_rate')->nullable()->default(0);
            $table->double('supplier_rate')->nullable()->default(0);
            $table->double('remise_client')->nullable()->default(0);
            $table->double('remise_supplier')->nullable()->default(0);
            $table->tinyInteger('mode_reglement')->nullable();
            $table->tinyInteger('cond_reglement')->nullable();
            $table->string('deposit_percent', 63)->nullable();
            $table->tinyInteger('transport_mode')->nullable();
            $table->tinyInteger('mode_reglement_supplier')->nullable();
            $table->tinyInteger('cond_reglement_supplier')->nullable();
            $table->tinyInteger('transport_mode_supplier')->nullable();
            $table->integer('fk_shipping_method')->nullable()->index('idx_societe_shipping_method');
            $table->tinyInteger('tva_assuj')->nullable()->default(1);
            $table->tinyInteger('vat_reverse_charge')->nullable()->default(0);
            $table->tinyInteger('localtax1_assuj')->nullable()->default(0);
            $table->double('localtax1_value', 7, 4)->nullable();
            $table->tinyInteger('localtax2_assuj')->nullable()->default(0);
            $table->double('localtax2_value', 7, 4)->nullable();
            $table->string('barcode', 180)->nullable();
            $table->integer('fk_barcode_type')->nullable()->default(0);
            $table->integer('price_level')->nullable();
            $table->double('outstanding_limit', 24, 8)->nullable();
            $table->double('order_min_amount', 24, 8)->nullable();
            $table->double('supplier_order_min_amount', 24, 8)->nullable();
            $table->string('default_lang', 6)->nullable();
            $table->string('logo')->nullable();
            $table->string('logo_squarred')->nullable();
            $table->string('canvas', 32)->nullable();
            $table->integer('fk_warehouse')->nullable();
            $table->string('webservices_url')->nullable();
            $table->string('webservices_key', 128)->nullable();
            $table->string('accountancy_code_sell', 32)->nullable();
            $table->string('accountancy_code_buy', 32)->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->dateTime('datec')->nullable();
            $table->integer('fk_user_creat')->nullable()->index('idx_societe_user_creat');
            $table->integer('fk_user_modif')->nullable()->index('idx_societe_user_modif');
            $table->integer('fk_multicurrency')->nullable();
            $table->string('multicurrency_code', 3)->nullable();
            $table->string('import_key', 14)->nullable();

            $table->unique(['prefix_comm', 'entity'], 'uk_societe_prefix_comm');
            $table->unique(['code_fournisseur', 'entity'], 'uk_societe_code_fournisseur');
            $table->unique(['code_client', 'entity'], 'uk_societe_code_client');
            $table->unique(['barcode', 'fk_barcode_type', 'entity'], 'uk_societe_barcode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('societe');
    }
};
