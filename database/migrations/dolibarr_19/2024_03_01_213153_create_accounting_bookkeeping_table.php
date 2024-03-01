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
        Schema::create('accounting_bookkeeping', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(1);
            $table->integer('piece_num');
            $table->date('doc_date')->index('idx_accounting_bookkeeping_doc_date');
            $table->string('doc_type', 30);
            $table->string('doc_ref', 300);
            $table->integer('fk_doc')->index('idx_accounting_bookkeeping_fk_doc');
            $table->integer('fk_docdet')->index('idx_accounting_bookkeeping_fk_docdet');
            $table->string('thirdparty_code', 32)->nullable();
            $table->string('subledger_account', 32)->nullable();
            $table->string('subledger_label')->nullable();
            $table->string('numero_compte', 32);
            $table->string('label_compte');
            $table->string('label_operation')->nullable();
            $table->double('debit', 24, 8);
            $table->double('credit', 24, 8);
            $table->double('montant', 24, 8)->nullable();
            $table->string('sens', 1)->nullable();
            $table->double('multicurrency_amount', 24, 8)->nullable();
            $table->string('multicurrency_code')->nullable();
            $table->string('lettering_code')->nullable();
            $table->dateTime('date_lettering')->nullable();
            $table->dateTime('date_lim_reglement')->nullable();
            $table->integer('fk_user_author');
            $table->integer('fk_user_modif')->nullable();
            $table->dateTime('date_creation')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_user')->nullable();
            $table->string('code_journal', 32);
            $table->string('journal_label')->nullable();
            $table->dateTime('date_validated')->nullable();
            $table->dateTime('date_export')->nullable();
            $table->string('import_key', 14)->nullable();
            $table->string('extraparams')->nullable();

            $table->index(['code_journal', 'entity'], 'idx_accounting_bookkeeping_code_journal');
            $table->index(['numero_compte', 'entity'], 'idx_accounting_bookkeeping_numero_compte');
            $table->index(['piece_num', 'entity'], 'idx_accounting_bookkeeping_piece_num');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounting_bookkeeping');
    }
};
