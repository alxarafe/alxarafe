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
        Schema::table('element_categorie', function (Blueprint $table) {
            $table->foreign(['fk_categorie'], 'fk_element_categorie_fk_categorie')->references(['rowid'])->on('categorie')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('element_categorie', function (Blueprint $table) {
            $table->dropForeign('fk_element_categorie_fk_categorie');
        });
    }
};
