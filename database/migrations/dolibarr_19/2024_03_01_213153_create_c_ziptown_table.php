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
        Schema::create('c_ziptown', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('code', 5)->nullable();
            $table->integer('fk_county')->nullable()->index('idx_c_ziptown_fk_county');
            $table->integer('fk_pays')->default(0)->index('idx_c_ziptown_fk_pays');
            $table->string('zip', 10)->index('idx_c_ziptown_zip');
            $table->string('town', 180);
            $table->string('town_up', 180)->nullable();
            $table->tinyInteger('active')->default(1);

            $table->unique(['zip', 'town', 'fk_pays'], 'uk_ziptown_fk_pays');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_ziptown');
    }
};
