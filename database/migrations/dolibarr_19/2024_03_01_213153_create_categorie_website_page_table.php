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
        Schema::create('categorie_website_page', function (Blueprint $table) {
            $table->integer('fk_categorie')->index('idx_categorie_website_page_fk_categorie');
            $table->integer('fk_website_page')->index('idx_categorie_website_page_fk_website_page');
            $table->string('import_key', 14)->nullable();

            $table->primary(['fk_categorie', 'fk_website_page']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categorie_website_page');
    }
};