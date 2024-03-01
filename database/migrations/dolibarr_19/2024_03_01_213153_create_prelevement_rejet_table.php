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
        Schema::create('prelevement_rejet', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_prelevement_lignes')->nullable();
            $table->dateTime('date_rejet')->nullable();
            $table->integer('motif')->nullable();
            $table->dateTime('date_creation')->nullable();
            $table->integer('fk_user_creation')->nullable();
            $table->text('note')->nullable();
            $table->tinyInteger('afacturer')->nullable()->default(0);
            $table->integer('fk_facture')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prelevement_rejet');
    }
};
