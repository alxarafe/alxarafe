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
        Schema::table('expeditiondet_batch', function (Blueprint $table) {
            $table->foreign(['fk_expeditiondet'], 'fk_expeditiondet_batch_fk_expeditiondet')->references(['rowid'])->on('expeditiondet')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expeditiondet_batch', function (Blueprint $table) {
            $table->dropForeign('fk_expeditiondet_batch_fk_expeditiondet');
        });
    }
};
