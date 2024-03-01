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
        Schema::create('bank_url', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_bank')->nullable();
            $table->integer('url_id')->nullable()->index('idx_bank_url_url_id');
            $table->string('url')->nullable();
            $table->string('label')->nullable();
            $table->string('type', 24);

            $table->unique(['fk_bank', 'url_id', 'type'], 'uk_bank_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_url');
    }
};
