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
        Schema::table('contratdet_log', function (Blueprint $table) {
            $table->foreign(['fk_contratdet'], 'fk_contratdet_log_fk_contratdet')->references(['rowid'])->on('contratdet')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contratdet_log', function (Blueprint $table) {
            $table->dropForeign('fk_contratdet_log_fk_contratdet');
        });
    }
};
