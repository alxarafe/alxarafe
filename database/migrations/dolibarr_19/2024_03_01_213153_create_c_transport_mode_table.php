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
        Schema::create('c_transport_mode', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(1);
            $table->string('code', 3);
            $table->string('label');
            $table->tinyInteger('active')->default(1);

            $table->unique(['code', 'entity'], 'uk_c_transport_mode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_transport_mode');
    }
};
