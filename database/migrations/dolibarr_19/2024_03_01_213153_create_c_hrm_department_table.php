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
        Schema::create('c_hrm_department', function (Blueprint $table) {
            $table->integer('rowid')->primary();
            $table->tinyInteger('pos')->default(0);
            $table->string('code', 16);
            $table->string('label', 128)->nullable();
            $table->tinyInteger('active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_hrm_department');
    }
};
