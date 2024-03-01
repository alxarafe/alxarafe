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
        Schema::table('c_departements', function (Blueprint $table) {
            $table->foreign(['fk_region'], 'fk_departements_fk_region')->references(['code_region'])->on('c_regions')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('c_departements', function (Blueprint $table) {
            $table->dropForeign('fk_departements_fk_region');
        });
    }
};
