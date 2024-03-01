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
        Schema::create('takepos_floor_tables', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(1);
            $table->string('label')->nullable();
            $table->float('leftpos', 10, 0)->nullable();
            $table->float('toppos', 10, 0)->nullable();
            $table->smallInteger('floor')->nullable();

            $table->unique(['entity', 'label'], 'uk_takepos_floor_tables');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('takepos_floor_tables');
    }
};
