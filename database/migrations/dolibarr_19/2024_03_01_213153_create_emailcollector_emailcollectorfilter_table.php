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
        Schema::create('emailcollector_emailcollectorfilter', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_emailcollector')->index('idx_emailcollector_fk_emailcollector');
            $table->string('type', 128);
            $table->string('rulevalue', 128)->nullable();
            $table->dateTime('date_creation');
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_user_creat');
            $table->integer('fk_user_modif')->nullable();
            $table->string('import_key', 14)->nullable();
            $table->integer('status');

            $table->unique(['fk_emailcollector', 'type', 'rulevalue'], 'uk_emailcollector_emailcollectorfilter');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emailcollector_emailcollectorfilter');
    }
};
