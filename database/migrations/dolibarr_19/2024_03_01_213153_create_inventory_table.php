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
        Schema::create('inventory', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('entity')->nullable()->default(0);
            $table->string('ref', 48)->nullable();
            $table->dateTime('date_creation')->nullable()->index('idx_inventory_date_creation');
            $table->timestamp('tms')->useCurrentOnUpdate()->nullable()->useCurrent()->index('idx_inventory_tms');
            $table->integer('fk_user_creat')->nullable();
            $table->integer('fk_user_modif')->nullable();
            $table->integer('fk_user_valid')->nullable();
            $table->integer('fk_warehouse')->nullable();
            $table->integer('fk_product')->nullable();
            $table->string('categories_product')->nullable();
            $table->integer('status')->nullable()->default(0);
            $table->string('title');
            $table->dateTime('date_inventory')->nullable();
            $table->dateTime('date_validation')->nullable();
            $table->string('import_key', 14)->nullable();

            $table->unique(['ref', 'entity'], 'uk_inventory_ref');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory');
    }
};
