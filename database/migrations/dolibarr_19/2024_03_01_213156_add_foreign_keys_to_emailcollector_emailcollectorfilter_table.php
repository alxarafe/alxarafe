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
        Schema::table('emailcollector_emailcollectorfilter', function (Blueprint $table) {
            $table->foreign(['fk_emailcollector'], 'fk_emailcollectorfilter_fk_emailcollector')->references(['rowid'])->on('emailcollector_emailcollector')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('emailcollector_emailcollectorfilter', function (Blueprint $table) {
            $table->dropForeign('fk_emailcollectorfilter_fk_emailcollector');
        });
    }
};
