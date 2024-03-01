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
        Schema::table('deliverydet', function (Blueprint $table) {
            $table->foreign(['fk_delivery'], 'fk_deliverydet_fk_delivery')->references(['rowid'])->on('delivery')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deliverydet', function (Blueprint $table) {
            $table->dropForeign('fk_deliverydet_fk_delivery');
        });
    }
};
