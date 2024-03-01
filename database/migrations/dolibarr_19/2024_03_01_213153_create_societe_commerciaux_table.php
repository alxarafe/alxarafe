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
        Schema::create('societe_commerciaux', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_soc')->nullable();
            $table->integer('fk_user')->nullable();
            $table->string('import_key', 14)->nullable();

            $table->unique(['fk_soc', 'fk_user'], 'uk_societe_commerciaux');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('societe_commerciaux');
    }
};
