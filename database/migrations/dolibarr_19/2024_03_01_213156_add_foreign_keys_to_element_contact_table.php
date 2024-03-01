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
        Schema::table('element_contact', function (Blueprint $table) {
            $table->foreign(['fk_c_type_contact'], 'fk_element_contact_fk_c_type_contact')->references(['rowid'])->on('c_type_contact')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('element_contact', function (Blueprint $table) {
            $table->dropForeign('fk_element_contact_fk_c_type_contact');
        });
    }
};
