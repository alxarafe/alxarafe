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
        Schema::create('printing', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->dateTime('datec')->nullable();
            $table->text('printer_name');
            $table->text('printer_location');
            $table->string('printer_id');
            $table->integer('copy')->default(1);
            $table->string('module', 16);
            $table->string('driver', 16);
            $table->integer('userid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('printing');
    }
};
