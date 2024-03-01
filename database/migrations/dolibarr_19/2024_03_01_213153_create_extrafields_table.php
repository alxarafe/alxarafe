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
        Schema::create('extrafields', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('name', 64);
            $table->integer('entity')->default(1);
            $table->string('elementtype', 64)->default('member');
            $table->string('label');
            $table->string('type', 8)->nullable();
            $table->string('size', 8)->nullable();
            $table->text('fieldcomputed')->nullable();
            $table->text('fielddefault')->nullable();
            $table->integer('fieldunique')->nullable()->default(0);
            $table->integer('fieldrequired')->nullable()->default(0);
            $table->string('perms')->nullable();
            $table->string('enabled')->nullable();
            $table->integer('pos')->nullable()->default(0);
            $table->integer('alwayseditable')->nullable()->default(0);
            $table->text('param')->nullable();
            $table->string('list')->nullable()->default('1');
            $table->integer('printable')->nullable()->default(0);
            $table->boolean('totalizable')->nullable()->default(false);
            $table->string('langs', 64)->nullable();
            $table->text('help')->nullable();
            $table->string('css', 128)->nullable();
            $table->string('cssview', 128)->nullable();
            $table->string('csslist', 128)->nullable();
            $table->integer('fk_user_author')->nullable();
            $table->integer('fk_user_modif')->nullable();
            $table->dateTime('datec')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();

            $table->unique(['name', 'entity', 'elementtype'], 'uk_extrafields_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('extrafields');
    }
};
