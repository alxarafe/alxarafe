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
        Schema::create('expedition_package', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_expedition');
            $table->string('description')->nullable();
            $table->double('value', 24, 8)->nullable()->default(0);
            $table->integer('fk_package_type')->nullable();
            $table->float('height', 10, 0)->nullable();
            $table->float('width', 10, 0)->nullable();
            $table->float('size', 10, 0)->nullable();
            $table->integer('size_units')->nullable();
            $table->float('weight', 10, 0)->nullable();
            $table->integer('weight_units')->nullable();
            $table->smallInteger('dangerous_goods')->nullable()->default(0);
            $table->smallInteger('tail_lift')->nullable()->default(0);
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
        Schema::dropIfExists('expedition_package');
    }
};
