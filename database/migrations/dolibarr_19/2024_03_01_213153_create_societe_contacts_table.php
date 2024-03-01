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
        Schema::create('societe_contacts', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->default(1);
            $table->dateTime('date_creation');
            $table->integer('fk_soc')->index('fk_societe_contacts_fk_soc');
            $table->integer('fk_c_type_contact')->index('fk_societe_contacts_fk_c_type_contact');
            $table->integer('fk_socpeople')->index('fk_societe_contacts_fk_socpeople');
            $table->timestamp('tms')->nullable();
            $table->string('import_key', 14)->nullable();

            $table->unique(['entity', 'fk_soc', 'fk_c_type_contact', 'fk_socpeople'], 'idx_societe_contacts_idx1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('societe_contacts');
    }
};
