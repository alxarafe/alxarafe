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
        Schema::create('element_time', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('ref_ext', 32)->nullable();
            $table->integer('fk_element')->index('idx_element_time_task');
            $table->string('elementtype', 32);
            $table->date('element_date')->nullable()->index('idx_element_time_date');
            $table->dateTime('element_datehour')->nullable()->index('idx_element_time_datehour');
            $table->integer('element_date_withhour')->nullable();
            $table->double('element_duration')->nullable();
            $table->integer('fk_product')->nullable();
            $table->integer('fk_user')->nullable();
            $table->double('thm', 24, 8)->nullable();
            $table->integer('invoice_id')->nullable();
            $table->integer('invoice_line_id')->nullable();
            $table->integer('intervention_id')->nullable();
            $table->integer('intervention_line_id')->nullable();
            $table->string('import_key', 14)->nullable();
            $table->dateTime('datec')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->text('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('element_time');
    }
};
