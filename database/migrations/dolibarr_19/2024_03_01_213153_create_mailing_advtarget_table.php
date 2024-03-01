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
        Schema::create('mailing_advtarget', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('name', 180)->unique('uk_advtargetemailing_name');
            $table->integer('entity')->default(1);
            $table->integer('fk_element');
            $table->string('type_element', 180);
            $table->text('filtervalue')->nullable();
            $table->integer('fk_user_author');
            $table->dateTime('datec');
            $table->integer('fk_user_mod');
            $table->timestamp('tms')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mailing_advtarget');
    }
};
