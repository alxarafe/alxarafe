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
        Schema::create('c_propalst', function (Blueprint $table) {
            $table->smallInteger('id')->primary();
            $table->string('code', 12)->unique('uk_c_propalst');
            $table->string('label', 128)->nullable();
            $table->smallInteger('sortorder')->nullable()->default(0);
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
        Schema::dropIfExists('c_propalst');
    }
};
