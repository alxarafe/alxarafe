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
        Schema::create('c_holiday_types', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('code', 16)->unique('uk_c_holiday_types');
            $table->string('label');
            $table->integer('affect');
            $table->integer('delay');
            $table->double('newbymonth', 8, 5)->default(0);
            $table->integer('fk_country')->nullable();
            $table->integer('block_if_negative')->default(0);
            $table->smallInteger('sortorder')->nullable();
            $table->integer('active')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_holiday_types');
    }
};
