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
        Schema::table('expeditiondet', function (Blueprint $table) {
            $table->foreign(['fk_expedition'], 'fk_expeditiondet_fk_expedition')->references(['rowid'])->on('expedition')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expeditiondet', function (Blueprint $table) {
            $table->dropForeign('fk_expeditiondet_fk_expedition');
        });
    }
};
