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
        Schema::create('printer_receipt_template', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('name', 128)->nullable();
            $table->text('template')->nullable();
            $table->integer('entity')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('printer_receipt_template');
    }
};
