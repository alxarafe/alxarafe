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
        Schema::create('actioncomm_resources', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_actioncomm');
            $table->string('element_type', 50);
            $table->integer('fk_element')->index('idx_actioncomm_resources_fk_element');
            $table->string('answer_status', 50)->nullable();
            $table->smallInteger('mandatory')->nullable();
            $table->smallInteger('transparency')->nullable()->default(1);

            $table->unique(['fk_actioncomm', 'element_type', 'fk_element'], 'uk_actioncomm_resources');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actioncomm_resources');
    }
};
