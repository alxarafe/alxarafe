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
        Schema::create('expeditiondet', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_expedition')->index('idx_expeditiondet_fk_expedition');
            $table->integer('fk_origin_line')->nullable()->index('idx_expeditiondet_fk_origin_line');
            $table->integer('fk_entrepot')->nullable();
            $table->double('qty')->nullable();
            $table->integer('rang')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expeditiondet');
    }
};
