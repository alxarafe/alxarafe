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
        Schema::create('actioncomm', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('ref', 30);
            $table->string('ref_ext')->nullable()->index('idx_actioncomm_ref_ext');
            $table->integer('entity')->default(1);
            $table->dateTime('datep')->nullable()->index('idx_actioncomm_datep');
            $table->dateTime('datep2')->nullable()->index('idx_actioncomm_datep2');
            $table->integer('fk_action')->nullable();
            $table->string('code', 50)->nullable()->index('idx_actioncomm_code');
            $table->dateTime('datec')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('fk_user_author')->nullable();
            $table->integer('fk_user_mod')->nullable();
            $table->integer('fk_project')->nullable()->index('idx_actioncomm_fk_project');
            $table->integer('fk_soc')->nullable()->index('idx_actioncomm_fk_soc');
            $table->integer('fk_contact')->nullable()->index('idx_actioncomm_fk_contact');
            $table->integer('fk_parent')->default(0);
            $table->integer('fk_user_action')->nullable()->index('idx_actioncomm_fk_user_action');
            $table->integer('fk_user_done')->nullable();
            $table->integer('transparency')->nullable();
            $table->smallInteger('priority')->nullable();
            $table->string('visibility', 12)->nullable()->default('default');
            $table->smallInteger('fulldayevent')->default(0);
            $table->smallInteger('percent')->default(0)->index('idx_actioncomm_percent');
            $table->string('location', 128)->nullable();
            $table->double('durationp')->nullable();
            $table->string('label');
            $table->mediumText('note')->nullable();
            $table->integer('calling_duration')->nullable();
            $table->string('email_subject')->nullable();
            $table->string('email_msgid')->nullable();
            $table->string('email_from')->nullable();
            $table->string('email_sender')->nullable();
            $table->string('email_to')->nullable();
            $table->string('email_tocc')->nullable();
            $table->string('email_tobcc')->nullable();
            $table->string('errors_to')->nullable();
            $table->string('reply_to')->nullable();
            $table->string('recurid', 128)->nullable()->index('idx_actioncomm_recurid');
            $table->string('recurrule', 128)->nullable();
            $table->dateTime('recurdateend')->nullable();
            $table->integer('num_vote')->nullable();
            $table->smallInteger('event_paid')->default(0);
            $table->smallInteger('status')->default(0);
            $table->integer('fk_element')->nullable()->index('idx_actioncomm_fk_element');
            $table->string('elementtype')->nullable();
            $table->string('ip', 250)->nullable();
            $table->integer('fk_bookcal_calendar')->nullable();
            $table->string('import_key', 14)->nullable();
            $table->string('extraparams')->nullable();

            $table->index(['ref', 'entity'], 'idx_actioncomm_ref');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actioncomm');
    }
};
