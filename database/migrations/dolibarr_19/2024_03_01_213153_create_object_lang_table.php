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
        Schema::create('object_lang', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_object')->default(0);
            $table->string('type_object', 32);
            $table->string('property', 32);
            $table->string('lang', 5)->default('');
            $table->text('value')->nullable();
            $table->string('import_key', 14)->nullable();

            $table->unique(['fk_object', 'type_object', 'property', 'lang'], 'uk_object_lang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('object_lang');
    }
};
