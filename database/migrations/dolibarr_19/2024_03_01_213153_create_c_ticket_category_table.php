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
        Schema::create('c_ticket_category', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->nullable()->default(1);
            $table->string('code', 32);
            $table->string('label', 128);
            $table->integer('public')->nullable()->default(0);
            $table->integer('use_default')->nullable()->default(1);
            $table->integer('fk_parent')->default(0);
            $table->string('force_severity', 32)->nullable();
            $table->string('description')->nullable();
            $table->integer('pos')->default(0);
            $table->integer('active')->nullable()->default(1);

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
        Schema::dropIfExists('c_ticket_category');
    }
};
