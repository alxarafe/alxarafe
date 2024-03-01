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
        Schema::create('bank', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->dateTime('datec')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->date('datev')->nullable()->index('idx_bank_datev');
            $table->date('dateo')->nullable()->index('idx_bank_dateo');
            $table->double('amount', 24, 8)->default(0);
            $table->double('amount_main_currency', 24, 8)->nullable();
            $table->string('label')->nullable();
            $table->integer('fk_account')->nullable()->index('idx_bank_fk_account');
            $table->integer('fk_user_author')->nullable();
            $table->integer('fk_user_rappro')->nullable();
            $table->string('fk_type', 6)->nullable();
            $table->string('num_releve', 50)->nullable()->index('idx_bank_num_releve');
            $table->string('num_chq', 50)->nullable();
            $table->string('numero_compte', 32)->nullable();
            $table->tinyInteger('rappro')->nullable()->default(0)->index('idx_bank_rappro');
            $table->text('note')->nullable();
            $table->integer('fk_bordereau')->nullable()->default(0);
            $table->integer('position')->nullable()->default(0);
            $table->string('banque')->nullable();
            $table->string('emetteur')->nullable();
            $table->string('author', 40)->nullable();
            $table->integer('origin_id')->nullable();
            $table->string('origin_type', 64)->nullable();
            $table->string('import_key', 14)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank');
    }
};
