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
        Schema::create('c_hrm_public_holiday', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('entity')->default(0);
            $table->integer('fk_country')->nullable();
            $table->integer('fk_departement')->nullable();
            $table->string('code', 62)->nullable();
            $table->string('dayrule', 64)->nullable()->default('');
            $table->integer('day')->nullable();
            $table->integer('month')->nullable();
            $table->integer('year')->nullable();
            $table->integer('active')->nullable()->default(1);
            $table->string('import_key', 14)->nullable();

            $table->unique(['entity', 'code'], 'uk_c_hrm_public_holiday');
            $table->unique(['entity', 'fk_country', 'dayrule', 'day', 'month', 'year'], 'uk_c_hrm_public_holiday2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_hrm_public_holiday');
    }
};
