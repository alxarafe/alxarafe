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
        Schema::create('propal_merge_pdf_product', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_product');
            $table->string('file_name', 200);
            $table->string('lang', 5)->nullable();
            $table->integer('fk_user_author')->nullable();
            $table->integer('fk_user_mod');
            $table->dateTime('datec');
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
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
        Schema::dropIfExists('propal_merge_pdf_product');
    }
};
