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
        Schema::create('c_shipment_package_type', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('label', 128);
            $table->string('description')->nullable();
            $table->integer('active')->default(1);
            $table->integer('entity')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_shipment_package_type');
    }
};
