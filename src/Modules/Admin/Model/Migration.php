<?php

namespace CoreModules\Admin\Model;

use Alxarafe\Base\Model\Model;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

/**
 * The "migrations" table contains the list of updates to the database tables.
 */
class Migration extends Model
{
    protected $table = 'migrations';
    protected $fillable = ['migration', 'batch'];

    public static function getLastBatch()
    {
        $instance = new static;

        if (!Capsule::schema()->hasTable($instance->getTable())) {
            static::createTable();
        }

        return static::max('batch') ?? 0;
    }

    /**
     * Create the migration table if it does not exist.
     *
     * @return void
     */
    private static function createTable()
    {
        Capsule::schema()->create('migrations', function (Blueprint $table) {
            $table->id();
            $table->string('migration');
            $table->integer('batch')->unsigned();
            $table->timestamps();
        });
    }

}
