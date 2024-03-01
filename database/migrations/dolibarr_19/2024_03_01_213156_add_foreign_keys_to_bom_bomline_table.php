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
        Schema::table('bom_bomline', function (Blueprint $table) {
            $table->foreign(['fk_bom'], 'llx_bom_bomline_fk_bom')->references(['rowid'])->on('bom_bom')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bom_bomline', function (Blueprint $table) {
            $table->dropForeign('llx_bom_bomline_fk_bom');
        });
    }
};
