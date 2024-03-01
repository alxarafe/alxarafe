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
        Schema::create('c_shipment_mode', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(1);
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->string('code', 30);
            $table->string('libelle', 128);
            $table->text('description')->nullable();
            $table->string('tracking')->nullable();
            $table->tinyInteger('active')->nullable()->default(0);
            $table->string('module', 32)->nullable();

            $table->unique(['code', 'entity'], 'uk_c_shipment_mode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_shipment_mode');
    }
};
