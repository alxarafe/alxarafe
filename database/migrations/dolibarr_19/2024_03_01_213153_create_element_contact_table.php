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
        Schema::create('element_contact', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->dateTime('datecreate')->nullable();
            $table->smallInteger('statut')->nullable()->default(5);
            $table->integer('element_id');
            $table->integer('fk_c_type_contact')->index('fk_element_contact_fk_c_type_contact');
            $table->integer('fk_socpeople')->index('idx_element_contact_fk_socpeople');

            $table->unique(['element_id', 'fk_c_type_contact', 'fk_socpeople'], 'idx_element_contact_idx1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('element_contact');
    }
};
