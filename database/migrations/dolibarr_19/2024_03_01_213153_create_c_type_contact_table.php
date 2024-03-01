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
        Schema::create('c_type_contact', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('element', 30);
            $table->string('source', 8)->default('external');
            $table->string('code', 32);
            $table->string('libelle', 128);
            $table->tinyInteger('active')->default(1);
            $table->string('module', 32)->nullable();
            $table->integer('position')->default(0);

            $table->unique(['element', 'source', 'code'], 'uk_c_type_contact_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_type_contact');
    }
};
