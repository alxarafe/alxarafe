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
        Schema::create('onlinesignature', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(1);
            $table->string('object_type', 32);
            $table->integer('object_id');
            $table->dateTime('datec');
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->string('name');
            $table->string('ip', 128)->nullable();
            $table->string('pathoffile')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('onlinesignature');
    }
};
