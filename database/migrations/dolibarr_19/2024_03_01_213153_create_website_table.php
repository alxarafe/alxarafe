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
        Schema::create('website', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('type_container', 16)->default('page');
            $table->integer('entity')->default(1);
            $table->string('ref', 128);
            $table->string('description')->nullable();
            $table->string('maincolor', 16)->nullable();
            $table->string('maincolorbis', 16)->nullable();
            $table->string('lang', 8)->nullable();
            $table->string('otherlang')->nullable();
            $table->integer('status')->nullable()->default(1);
            $table->integer('fk_default_home')->nullable();
            $table->integer('use_manifest')->nullable();
            $table->string('virtualhost')->nullable();
            $table->integer('fk_user_creat')->nullable();
            $table->integer('fk_user_modif')->nullable();
            $table->dateTime('date_creation')->nullable();
            $table->integer('position')->nullable()->default(0);
            $table->dateTime('lastaccess')->nullable();
            $table->unsignedBigInteger('pageviews_previous_month')->nullable()->default(0);
            $table->unsignedBigInteger('pageviews_month')->nullable()->default(0);
            $table->unsignedBigInteger('pageviews_total')->nullable()->default(0);
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->string('import_key', 14)->nullable();

            $table->unique(['ref', 'entity'], 'uk_website_ref');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('website');
    }
};
