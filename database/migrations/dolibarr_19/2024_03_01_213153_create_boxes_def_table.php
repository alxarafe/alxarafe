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
        Schema::create('boxes_def', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('file', 200);
            $table->integer('entity')->default(1);
            $table->integer('fk_user')->default(0);
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->string('note', 130)->nullable();

            $table->unique(['file', 'entity', 'note'], 'uk_boxes_def');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boxes_def');
    }
};
