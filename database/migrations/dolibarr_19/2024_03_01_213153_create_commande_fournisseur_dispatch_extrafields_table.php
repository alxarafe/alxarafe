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
        Schema::create('commande_fournisseur_dispatch_extrafields', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_object')->index('idx_commande_fournisseur_dispatch_extrafields');
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
        Schema::dropIfExists('commande_fournisseur_dispatch_extrafields');
    }
};
