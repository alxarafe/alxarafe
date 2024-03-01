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
        Schema::table('expedition', function (Blueprint $table) {
            $table->foreign(['fk_shipping_method'], 'fk_expedition_fk_shipping_method')->references(['rowid'])->on('c_shipment_mode')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_soc'], 'fk_expedition_fk_soc')->references(['rowid'])->on('societe')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_user_author'], 'fk_expedition_fk_user_author')->references(['rowid'])->on('user')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_user_valid'], 'fk_expedition_fk_user_valid')->references(['rowid'])->on('user')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expedition', function (Blueprint $table) {
            $table->dropForeign('fk_expedition_fk_shipping_method');
            $table->dropForeign('fk_expedition_fk_soc');
            $table->dropForeign('fk_expedition_fk_user_author');
            $table->dropForeign('fk_expedition_fk_user_valid');
        });
    }
};
