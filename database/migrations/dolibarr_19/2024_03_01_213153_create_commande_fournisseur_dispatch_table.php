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
        Schema::create('commande_fournisseur_dispatch', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_product')->nullable()->index('idx_commande_fournisseur_dispatch_fk_product');
            $table->integer('fk_commande')->nullable()->index('idx_commande_fournisseur_dispatch_fk_commande');
            $table->integer('fk_commandefourndet')->nullable()->index('idx_commande_fournisseur_dispatch_fk_commandefourndet');
            $table->string('element_type', 50)->default('supplier_order');
            $table->integer('fk_projet')->nullable();
            $table->integer('fk_reception')->nullable()->index('idx_commande_fournisseur_dispatch_fk_reception');
            $table->float('qty', 10, 0)->nullable();
            $table->integer('fk_entrepot')->nullable();
            $table->string('comment')->nullable();
            $table->string('batch', 128)->nullable();
            $table->date('eatby')->nullable();
            $table->date('sellby')->nullable();
            $table->integer('status')->nullable();
            $table->integer('fk_user')->nullable();
            $table->dateTime('datec')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->double('cost_price', 24, 8)->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commande_fournisseur_dispatch');
    }
};
