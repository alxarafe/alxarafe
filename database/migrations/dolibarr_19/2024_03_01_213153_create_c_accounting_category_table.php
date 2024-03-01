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
        Schema::create('c_accounting_category', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(1);
            $table->string('code', 16);
            $table->string('label');
            $table->string('range_account');
            $table->tinyInteger('sens')->default(0);
            $table->tinyInteger('category_type')->default(0);
            $table->string('formula');
            $table->integer('position')->nullable()->default(0);
            $table->integer('fk_country')->nullable();
            $table->integer('active')->nullable()->default(1);

            $table->unique(['code', 'entity'], 'uk_c_accounting_category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_accounting_category');
    }
};
