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
        Schema::create('categorie_actioncomm', function (Blueprint $table) {
            $table->integer('fk_categorie')->index('idx_categorie_actioncomm_fk_categorie');
            $table->integer('fk_actioncomm')->index('idx_categorie_actioncomm_fk_actioncomm');
            $table->string('import_key', 14)->nullable();

            $table->primary(['fk_categorie', 'fk_actioncomm']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categorie_actioncomm');
    }
};
