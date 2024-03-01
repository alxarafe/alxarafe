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
        Schema::create('website_page', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_website');
            $table->string('type_container', 16)->default('page');
            $table->string('pageurl');
            $table->string('aliasalt')->nullable();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->string('keywords')->nullable();
            $table->string('lang', 6)->nullable();
            $table->integer('fk_page')->nullable();
            $table->integer('allowed_in_frames')->nullable()->default(0);
            $table->text('htmlheader')->nullable();
            $table->mediumText('content')->nullable();
            $table->integer('status')->nullable()->default(1);
            $table->string('grabbed_from')->nullable();
            $table->integer('fk_user_creat')->nullable();
            $table->integer('fk_user_modif')->nullable();
            $table->string('author_alias', 64)->nullable();
            $table->dateTime('date_creation')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->string('import_key', 14)->nullable();
            $table->string('object_type')->nullable();
            $table->string('fk_object')->nullable();

            $table->unique(['fk_website', 'pageurl'], 'uk_website_page_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('website_page');
    }
};
