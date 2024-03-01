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
        Schema::create('c_paper_format', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('code', 16);
            $table->string('label', 128);
            $table->float('width', 6)->nullable()->default(0);
            $table->float('height', 6)->nullable()->default(0);
            $table->string('unit', 5);
            $table->tinyInteger('active')->default(1);
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
        Schema::dropIfExists('c_paper_format');
    }
};
