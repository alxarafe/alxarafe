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
        Schema::create('stocktransfer_stocktransferline', function (Blueprint $table) {
            $table->integer('rowid', true)->index('idx_stocktransfer_stocktransferline_rowid');
            $table->double('amount')->nullable();
            $table->double('qty')->nullable();
            $table->integer('fk_warehouse_source');
            $table->integer('fk_warehouse_destination');
            $table->integer('fk_stocktransfer');
            $table->integer('fk_product');
            $table->string('batch', 128)->nullable();
            $table->double('pmp')->nullable();
            $table->integer('rang')->nullable()->default(0);
            $table->integer('fk_parent_line')->nullable();

            $table->primary(['rowid']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocktransfer_stocktransferline');
    }
};
