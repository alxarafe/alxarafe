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
        Schema::create('categorie_project', function (Blueprint $table) {
            $table->integer('fk_categorie')->index('idx_categorie_project_fk_categorie');
            $table->integer('fk_project')->index('idx_categorie_project_fk_project');
            $table->string('import_key', 14)->nullable();

            $table->primary(['fk_categorie', 'fk_project']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categorie_project');
    }
};
