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
        Schema::create('c_stcommcontact', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('code', 12)->unique('uk_c_stcommcontact');
            $table->string('libelle', 128)->nullable();
            $table->string('picto', 128)->nullable();
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
        Schema::dropIfExists('c_stcommcontact');
    }
};
