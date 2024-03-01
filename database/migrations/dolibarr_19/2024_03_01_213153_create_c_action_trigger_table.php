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
        Schema::create('c_action_trigger', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('elementtype', 64);
            $table->string('code', 128)->unique('uk_action_trigger_code');
            $table->string('contexts')->nullable();
            $table->string('label', 128);
            $table->string('description')->nullable();
            $table->integer('rang')->nullable()->default(0)->index('idx_action_trigger_rang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_action_trigger');
    }
};
