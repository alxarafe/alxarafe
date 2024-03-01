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
        Schema::table('societe_contacts', function (Blueprint $table) {
            $table->foreign(['fk_c_type_contact'], 'fk_societe_contacts_fk_c_type_contact')->references(['rowid'])->on('c_type_contact')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_soc'], 'fk_societe_contacts_fk_soc')->references(['rowid'])->on('societe')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['fk_socpeople'], 'fk_societe_contacts_fk_socpeople')->references(['rowid'])->on('socpeople')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('societe_contacts', function (Blueprint $table) {
            $table->dropForeign('fk_societe_contacts_fk_c_type_contact');
            $table->dropForeign('fk_societe_contacts_fk_soc');
            $table->dropForeign('fk_societe_contacts_fk_socpeople');
        });
    }
};
