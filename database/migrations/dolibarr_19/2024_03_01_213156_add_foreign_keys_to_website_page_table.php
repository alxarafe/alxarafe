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
        Schema::table('website_page', function (Blueprint $table) {
            $table->foreign(['fk_website'], 'fk_website_page_website')->references(['rowid'])->on('website')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('website_page', function (Blueprint $table) {
            $table->dropForeign('fk_website_page_website');
        });
    }
};
