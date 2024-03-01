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
        Schema::create('c_lead_status', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('code', 10)->nullable()->unique('uk_c_lead_status_code');
            $table->string('label', 128)->nullable();
            $table->integer('position')->nullable();
            $table->double('percent', 5, 2)->nullable();
            $table->tinyInteger('active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_lead_status');
    }
};
