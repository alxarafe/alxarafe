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
        Schema::create('blockedlog_authority', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->longText('blockchain');
            $table->string('signature', 100)->index('signature');
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blockedlog_authority');
    }
};
