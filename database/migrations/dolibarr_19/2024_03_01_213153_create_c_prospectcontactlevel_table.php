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
        Schema::create('c_prospectcontactlevel', function (Blueprint $table) {
            $table->string('code', 12)->primary();
            $table->string('label', 128)->nullable();
            $table->smallInteger('sortorder')->nullable();
            $table->smallInteger('active')->default(1);
            $table->string('module', 32)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_prospectcontactlevel');
    }
};
