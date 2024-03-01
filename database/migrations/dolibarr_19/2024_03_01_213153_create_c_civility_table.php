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
        Schema::create('c_civility', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('code', 6)->unique('uk_c_civility');
            $table->string('label', 128)->nullable();
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
        Schema::dropIfExists('c_civility');
    }
};
