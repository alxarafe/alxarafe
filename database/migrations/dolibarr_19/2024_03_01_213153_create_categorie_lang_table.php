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
        Schema::create('categorie_lang', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_category')->default(0);
            $table->string('lang', 5)->default('0');
            $table->string('label');
            $table->text('description')->nullable();

            $table->unique(['fk_category', 'lang'], 'uk_category_lang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categorie_lang');
    }
};
