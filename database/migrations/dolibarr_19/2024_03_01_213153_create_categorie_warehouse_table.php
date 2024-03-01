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
        Schema::create('categorie_warehouse', function (Blueprint $table) {
            $table->integer('fk_categorie')->index('idx_categorie_warehouse_fk_categorie');
            $table->integer('fk_warehouse')->index('idx_categorie_warehouse_fk_warehouse');
            $table->string('import_key', 14)->nullable();

            $table->primary(['fk_categorie', 'fk_warehouse']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categorie_warehouse');
    }
};
