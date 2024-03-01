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
        Schema::table('c_regions', function (Blueprint $table) {
            $table->foreign(['fk_pays'], 'fk_c_regions_fk_pays')->references(['rowid'])->on('c_country')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('c_regions', function (Blueprint $table) {
            $table->dropForeign('fk_c_regions_fk_pays');
        });
    }
};
