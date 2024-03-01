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
        Schema::create('accounting_account', function (Blueprint $table) {
            $table->bigInteger('rowid', true);
            $table->integer('entity')->default(1);
            $table->dateTime('datec')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->string('fk_pcg_version', 32)->index('idx_accounting_account_fk_pcg_version');
            $table->string('pcg_type', 60);
            $table->string('account_number', 32);
            $table->integer('account_parent')->nullable()->default(0)->index('idx_accounting_account_account_parent');
            $table->string('label');
            $table->string('labelshort')->nullable();
            $table->integer('fk_accounting_category')->nullable()->default(0);
            $table->integer('fk_user_author')->nullable();
            $table->integer('fk_user_modif')->nullable();
            $table->tinyInteger('active')->default(1);
            $table->tinyInteger('reconcilable')->default(0);
            $table->string('import_key', 14)->nullable();
            $table->string('extraparams')->nullable();

            $table->unique(['account_number', 'entity', 'fk_pcg_version'], 'uk_accounting_account');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounting_account');
    }
};
