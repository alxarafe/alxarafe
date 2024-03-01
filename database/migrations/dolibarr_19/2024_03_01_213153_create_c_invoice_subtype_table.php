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
        Schema::create('c_invoice_subtype', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(1);
            $table->integer('fk_country');
            $table->string('code', 5);
            $table->string('label', 100)->nullable();
            $table->tinyInteger('active')->default(1);

            $table->unique(['entity', 'code', 'fk_country'], 'uk_c_invoice_subtype');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_invoice_subtype');
    }
};
