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
        Schema::create('c_format_cards', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('code', 50);
            $table->string('name', 50);
            $table->string('paper_size', 20);
            $table->string('orientation', 1);
            $table->string('metric', 5);
            $table->double('leftmargin', 24, 8);
            $table->double('topmargin', 24, 8);
            $table->integer('nx');
            $table->integer('ny');
            $table->double('spacex', 24, 8);
            $table->double('spacey', 24, 8);
            $table->double('width', 24, 8);
            $table->double('height', 24, 8);
            $table->integer('font_size');
            $table->double('custom_x', 24, 8);
            $table->double('custom_y', 24, 8);
            $table->integer('active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_format_cards');
    }
};
