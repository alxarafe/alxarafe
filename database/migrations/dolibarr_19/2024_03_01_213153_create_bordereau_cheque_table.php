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
        Schema::create('bordereau_cheque', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('ref', 30);
            $table->string('label')->nullable();
            $table->string('ref_ext')->nullable();
            $table->string('type', 6)->nullable()->default('CHQ');
            $table->dateTime('datec');
            $table->date('date_bordereau')->nullable();
            $table->double('amount', 24, 8);
            $table->smallInteger('nbcheque');
            $table->integer('fk_bank_account')->nullable();
            $table->integer('fk_user_author')->nullable();
            $table->smallInteger('statut')->default(0);
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->text('note')->nullable();
            $table->integer('entity')->default(1);

            $table->unique(['ref', 'entity'], 'uk_bordereau_cheque');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bordereau_cheque');
    }
};
