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
        Schema::create('c_socialnetworks', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(1);
            $table->string('code', 100)->nullable();
            $table->string('label', 150)->nullable();
            $table->text('url')->nullable();
            $table->string('icon', 20)->nullable();
            $table->tinyInteger('active')->default(1);

            $table->unique(['entity', 'code'], 'idx_c_socialnetworks_code_entity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_socialnetworks');
    }
};
