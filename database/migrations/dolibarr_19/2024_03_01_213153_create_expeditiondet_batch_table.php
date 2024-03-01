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
        Schema::create('expeditiondet_batch', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_expeditiondet')->index('idx_fk_expeditiondet');
            $table->date('eatby')->nullable();
            $table->date('sellby')->nullable();
            $table->string('batch', 128)->nullable();
            $table->double('qty')->default(0);
            $table->integer('fk_origin_stock');
            $table->integer('fk_warehouse')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expeditiondet_batch');
    }
};
