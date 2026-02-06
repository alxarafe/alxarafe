<?php

namespace CoreModules\Admin\Model;

use Alxarafe\Base\Model\Model;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

/**
 * The "migrations" table contains the list of updates to the database tables.
 */
final class Migration extends Model
{
    protected $table = 'migrations';
    protected $fillable = ['migration', 'batch'];

    public static function getLastBatch()
    {
        $instance = new self();

        if (!Capsule::schema()->hasTable($instance->getTable())) {
            self::createTable();
        }

        return self::max('batch') ?? 0;
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

    public function exists($exists = false): bool
    {
        if (!Capsule::schema()->hasTable($this->getTable())) {
            self::createTable();
            return false;
        }
        return parent::exists($exists);
    }
}
