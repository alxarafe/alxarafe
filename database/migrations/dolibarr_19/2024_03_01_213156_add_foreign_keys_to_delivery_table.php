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
        Schema::table('delivery', function (Blueprint $table) {
            $table->foreign(['fk_soc'], 'fk_delivery_fk_soc')->references(['rowid'])->on('societe')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_user_author'], 'fk_delivery_fk_user_author')->references(['rowid'])->on('user')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_user_valid'], 'fk_delivery_fk_user_valid')->references(['rowid'])->on('user')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('delivery', function (Blueprint $table) {
            $table->dropForeign('fk_delivery_fk_soc');
            $table->dropForeign('fk_delivery_fk_user_author');
            $table->dropForeign('fk_delivery_fk_user_valid');
        });
    }
};
