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
        Schema::create('blockedlog', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(1)->index('entity');
            $table->dateTime('date_creation')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->string('action', 50)->nullable();
            $table->double('amounts', 24, 8);
            $table->string('element', 50)->nullable();
            $table->integer('fk_user')->nullable()->index('fk_user');
            $table->string('user_fullname')->nullable();
            $table->integer('fk_object')->nullable();
            $table->string('ref_object')->nullable();
            $table->dateTime('date_object')->nullable();
            $table->string('signature', 100)->index('signature');
            $table->string('signature_line', 100);
            $table->mediumText('object_data')->nullable();
            $table->string('object_version', 32)->nullable()->default('');
            $table->integer('certified')->nullable();

            $table->index(['entity', 'action'], 'entity_action');
            $table->index(['entity', 'action', 'certified'], 'entity_action_certified');
            $table->index(['fk_object', 'element'], 'fk_object_element');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blockedlog');
    }
};
