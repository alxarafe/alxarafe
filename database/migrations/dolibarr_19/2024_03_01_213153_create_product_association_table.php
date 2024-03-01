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
        Schema::create('product_association', function (Blueprint $table) {
            $table->integer('rowid', true);
            $table->integer('fk_product_pere')->default(0);
            $table->integer('fk_product_fils')->default(0)->index('idx_product_association_fils');
            $table->double('qty')->nullable();
            $table->integer('incdec')->nullable()->default(1);
            $table->integer('rang')->nullable()->default(0);

            $table->unique(['fk_product_pere', 'fk_product_fils'], 'uk_product_association');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_association');
    }
};
