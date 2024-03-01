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
        Schema::table('supplier_proposaldet', function (Blueprint $table) {
            $table->foreign(['fk_supplier_proposal'], 'fk_supplier_proposaldet_fk_supplier_proposal')->references(['rowid'])->on('supplier_proposal')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_unit'], 'fk_supplier_proposaldet_fk_unit')->references(['rowid'])->on('c_units')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('supplier_proposaldet', function (Blueprint $table) {
            $table->dropForeign('fk_supplier_proposaldet_fk_supplier_proposal');
            $table->dropForeign('fk_supplier_proposaldet_fk_unit');
        });
    }
};
