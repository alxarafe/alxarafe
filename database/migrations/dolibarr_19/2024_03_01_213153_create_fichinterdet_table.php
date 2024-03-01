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
        Schema::create('fichinterdet', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_fichinter')->nullable()->index('idx_fichinterdet_fk_fichinter');
            $table->integer('fk_parent_line')->nullable();
            $table->dateTime('date')->nullable();
            $table->text('description')->nullable();
            $table->integer('duree')->nullable();
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
        Schema::dropIfExists('fichinterdet');
    }
};
