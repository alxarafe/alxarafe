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
        Schema::create('c_ticket_severity', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->nullable()->default(1);
            $table->string('code', 32);
            $table->string('pos', 32);
            $table->string('label', 128);
            $table->string('color', 10)->nullable();
            $table->integer('active')->nullable()->default(1);
            $table->integer('use_default')->nullable()->default(1);
            $table->string('description')->nullable();

            $table->unique(['code', 'entity'], 'uk_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_ticket_severity');
    }
};
