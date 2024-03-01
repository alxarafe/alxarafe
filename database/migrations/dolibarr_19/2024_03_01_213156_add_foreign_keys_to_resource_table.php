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
        Schema::table('resource', function (Blueprint $table) {
            $table->foreign(['fk_country'], 'fk_resource_fk_country')->references(['rowid'])->on('c_country')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resource', function (Blueprint $table) {
            $table->dropForeign('fk_resource_fk_country');
        });
    }
};
