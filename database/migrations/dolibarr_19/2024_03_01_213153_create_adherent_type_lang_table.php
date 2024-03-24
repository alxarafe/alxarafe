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
        Schema::create('adherent_type_lang', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_type')->default(0);
            $table->string('lang', 5)->default('0');
            $table->string('label');
            $table->text('description')->nullable();
            $table->text('email')->nullable();
            $table->string('import_key', 14)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adherent_type_lang');
    }
};