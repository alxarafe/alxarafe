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
        Schema::create('entrepot', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->string('ref');
            $table->dateTime('datec')->nullable();
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('entity')->default(1);
            $table->integer('fk_project')->nullable();
            $table->text('description')->nullable();
            $table->string('lieu', 64)->nullable();
            $table->string('address')->nullable();
            $table->string('zip', 10)->nullable();
            $table->string('town', 50)->nullable();
            $table->integer('fk_departement')->nullable();
            $table->integer('fk_pays')->nullable()->default(0);
            $table->string('phone', 20)->nullable();
            $table->string('fax', 20)->nullable();
            $table->string('barcode', 180)->nullable();
            $table->integer('fk_barcode_type')->nullable();
            $table->integer('warehouse_usage')->nullable()->default(1);
            $table->tinyInteger('statut')->nullable()->default(1);
            $table->integer('fk_user_author')->nullable();
            $table->string('model_pdf')->nullable();
            $table->string('import_key', 14)->nullable();
            $table->integer('fk_parent')->nullable()->default(0);

            $table->unique(['ref', 'entity'], 'uk_entrepot_label');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entrepot');
    }
};
